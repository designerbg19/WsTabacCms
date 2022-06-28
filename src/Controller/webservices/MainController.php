<?php
namespace App\Controller\webservices;

use App\Entity\Cycle;
use App\Entity\File;
use App\Entity\PdvPresentoire;
use App\Service\FileUploader;
use FOS\RestBundle\Controller\Annotations as Rest;
use Knp\Component\Pager\PaginatorInterface;
use PhpParser\Node\Expr\Cast\Object_;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use JMS\Serializer\SerializerBuilder;
use JMS\Serializer\SerializationContext;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class MainController extends AbstractController
{
    // Show Number of item per page (paginator)
    const NUMBER_ITEM_PER_PAGE = 13;
    // Titulaire - Gerant - Operateur Id
    const TITULAIRE_ID = 1;
    const GERANT_ID = 2;
    const OPERATEUR_ID = 3;

    // Classement POS Images in Entity File
    const IMAGE_TITULAIRE_CLASSMENT = 0;
    const IMAGE_GERANT_CLASSMENT = 1;
    const IMAGE_OPERATEUR_CLASSMENT = 2;
    const IMAGE_LICENCE_CLASSMENT = 3;

    public $em;
    public $passwordEncoder;
    /**
     * @var PaginatorInterface
     */
    public $paginator;

    public function __construct( UserPasswordEncoderInterface $passwordEncoder, EntityManagerInterface $em,PaginatorInterface $paginator)
    {
        $this->em = $em;
        $this->passwordEncoder = $passwordEncoder;
        $this->paginator = $paginator;
    }

    /**
     * @param $object
     * @return Response
     */
    public function successResponse($object )
    {
        $serializer = SerializerBuilder::create()->build();
        //$data = $serializer->serialize($object, 'json',SerializationContext::create()->setGroups(array($groups)));
        $data = $serializer->serialize($object, 'json');
        $response = new Response($data);
        $response->headers->set('Content-type','application/json');
        $response->headers->set('Access-Control-Allow-Origin','*');
        return $response;
    }

    /**
     * Function To Find The Number Of Cycle From Current Day
     * @return array [cycleId,numberOfCycle]
     * @throws \Exception
     */
    public  function getCurrentCycleNumberByDateNow()
    {
        //$todayDate =  date('Y-m-d');
        //Manual Date for test

        $todayDate = (new \DateTime("2019-08-26T14:45:23+00:00"))->format('Y-m-d');
        $cyclesObject = $this->em->getRepository(Cycle::class)->findAll();
        foreach ($cyclesObject as $cycleObject){
            $startDate= ($cycleObject->getDateDebut())->format('Y-m-d');
            $endDate= ($cycleObject->getDateFin())->format('Y-m-d');
            if($todayDate>=$startDate && $todayDate<=$endDate)
            {
                $numCycle = $cycleObject->getNumCycle();
            }
        }
        $cycleObject = $this->em->getRepository(Cycle::class)->findOneBy(['numCycle'=>$numCycle]);
        $cycleId = $cycleObject->getId();
        return array($cycleId,$numCycle);
    }

    /**
     * Function for rundom password for the merchs (generate password)
     * @param int $numberOfChars
     * @return string
     */
    public function randomPassword(int $numberOfChars) {
        $alphabet = "abcdefghijklmnopqrstuwxyzABCDEFGHIJKLMNOPQRSTUWXYZ0123456789";
        $pass = array(); //remember to declare $pass as an array
        $alphaLength = strlen($alphabet) - 1; //put the length -1 in cache
        for ($i = 0; $i < $numberOfChars; $i++) {
            $n = rand(0, $alphaLength);
            $pass[] = $alphabet[$n];
        }
        return implode($pass); //turn the array into a string
    }

    public function encryptIt( $plaintext ) {
        $key  = 'qJB0rGtIn5UB1xG03efyCp';
        $ivlen = openssl_cipher_iv_length($cipher="AES-128-CBC");
        $iv = openssl_random_pseudo_bytes($ivlen);
        $ciphertext_raw = openssl_encrypt($plaintext, $cipher, $key, $options=OPENSSL_RAW_DATA, $iv);
        $hmac = hash_hmac('sha256', $ciphertext_raw, $key, $as_binary=true);
        $ciphertext = base64_encode( $iv.$hmac.$ciphertext_raw );
        return $ciphertext;
    }

    public function decryptIt( $cryptedText ) {
        $ciphertext = substr($cryptedText,16);
        $key  = 'qJB0rGtIn5UB1xG03efyCp';
        $c = base64_decode($ciphertext);
        $ivlen = openssl_cipher_iv_length($cipher="AES-128-CBC");
        $iv = substr($c, 0, $ivlen);
        $hmac = substr($c, $ivlen, $sha2len=32);
        $ciphertext_raw = substr($c, $ivlen+$sha2len);
        $original_plaintext = openssl_decrypt($ciphertext_raw, $cipher, $key, $options=OPENSSL_RAW_DATA, $iv);
        return $original_plaintext;
    }

    /**
     * Function de inlink images from folder before delete
     * @param Object $object
     *
     */
    public function unlinkImages(Object $object ,$folder) {
        $files =$object->getFile();
        foreach ($files as $file){
            $paths[]=$folder.'/'.$file->getLabel();
        }
        if(!empty($paths)){
            foreach ($paths as $path){
                unlink($path);
            }
        }

    }



    /**
     * Create Image params (shop/pdvPresontoire/)
     */
    public function saveImageFilePresontoire(Object  $object, $uplodedImage)
    {
        $fileUploader = new  FileUploader($this->getParameter('images_param_directory'));
        $fileName = $fileUploader->upload($uplodedImage);
        $path = '/uploads/param/' . $fileName;
        $file = new File();
        $file->setLabel($fileName);
        $file->setPath($path);
        $this->em->persist($file);
        $this->em->flush();
        $object->setImage($file);
    }


    /**
     * Unlink image of params(shop/tposm/presentoire)
     * @param Object $object
     * @author youssef
     */
    public function unlinkParamsImage(Object $object)
    {
        if ($object->getImage()) {
            // unlink images from folder
            $file = $object->getImage();
            $folder = $this->getParameter('images_param_directory');
            $paths =$folder.'/'.$file->getLabel();
            if($paths){
                unlink($paths);
            }
        }
    }
}
