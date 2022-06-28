<?php

namespace App\Repository;

use App\Entity\Client;
use App\Entity\MarketingRecette;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Query;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Client|null find($id, $lockMode = null, $lockVersion = null)
 * @method Client|null findOneBy(array $criteria, array $orderBy = null)
 * @method Client[]    findAll()
 * @method Client[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ClientRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Client::class);
    }


    public function findNomDecideur($value)
    {
        $qb = $this->_em->createQueryBuilder();
        $result = $qb->select('tc.nom')
            ->from('App\Entity\Client', 'a')
            ->innerJoin('App\Entity\InfDecideur', 'tc')
            ->andWhere('a.id = :val')
            ->andWhere('a.decideur= tc.id')
            ->setParameter('val', $value)
            ->orderBy('a.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult();
        return $result;
    }

    public function findNomsuperficie($value)
    {
        $qb = $this->_em->createQueryBuilder();
        $result = $qb->select('tc.label')
            ->from('App\Entity\Client', 'a')
            ->innerJoin('App\Entity\PdvSuperficie', 'tc')
            ->andWhere('a.id = :val')
            ->andWhere('a.superficie= tc.id')
            ->setParameter('val', $value)
            ->orderBy('a.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult();
        return $result;
    }

    public function findNomemlacement($value)
    {
        $qb = $this->_em->createQueryBuilder();
        $result = $qb->select('tc.label')
            ->from('App\Entity\Client', 'a')
            ->innerJoin('App\Entity\PdvEmplacements', 'tc')
            ->andWhere('a.id = :val')
            ->andWhere('a.emplacement= tc.id')
            ->setParameter('val', $value)
            ->orderBy('a.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult();
        return $result;
    }

    public function findNomenvironnement($value)
    {
        $qb = $this->_em->createQueryBuilder();
        $result = $qb->select('tc.label')
            ->from('App\Entity\Client', 'a')
            ->innerJoin('App\Entity\PdvEnvironnements', 'tc')
            ->andWhere('a.id = :val')
            ->andWhere('a.environnement= tc.id')
            ->setParameter('val', $value)
            ->orderBy('a.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult();
        return $result;
    }

    public function findNomtypeDequartier($value)
    {
        $qb = $this->_em->createQueryBuilder();
        $result = $qb->select('tc.label')
            ->from('App\Entity\Client', 'a')
            ->innerJoin('App\Entity\PdvTypesQuartier', 'tc')
            ->andWhere('a.id = :val')
            ->andWhere('a.typeDeQuartier= tc.id')
            ->setParameter('val', $value)
            ->orderBy('a.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult();
        return $result;
    }

    public function findNomvisibiliter($value)
    {
        $qb = $this->_em->createQueryBuilder();
        $result = $qb->select('tc.label')
            ->from('App\Entity\Client', 'a')
            ->innerJoin('App\Entity\PdvVisibilite', 'tc')
            ->andWhere('a.id = :val')
            ->andWhere('a.visibiliter= tc.id')
            ->setParameter('val', $value)
            ->orderBy('a.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult();
        return $result;
    }

    public function findNomclassess($value)
    {
        $qb = $this->_em->createQueryBuilder();
        $result = $qb->select('tc.label')
            ->from('App\Entity\Client', 'a')
            ->innerJoin('App\Entity\PdvClasses', 'tc')
            ->andWhere('a.id = :val')
            ->andWhere('a.classe= tc.id')
            ->setParameter('val', $value)
            ->orderBy('a.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult();
        return $result;
    }

    public function findNomtypologie($value)
    {
        $qb = $this->_em->createQueryBuilder();
        $result = $qb->select('tc.label')
            ->from('App\Entity\Client', 'a')
            ->innerJoin('App\Entity\PdvTypologies', 'tc')
            ->andWhere('a.id = :val')
            ->andWhere('a.typologie= tc.id')
            ->setParameter('val', $value)
            ->orderBy('a.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult();
        return $result;
    }

    public function findNompresentoire($value)
    {
        $qb = $this->_em->createQueryBuilder();
        $result = $qb->select('tc.label')
            ->from('App\Entity\Client', 'a')
            ->innerJoin('App\Entity\PdvPresentoire', 'tc')
            ->andWhere('a.id = :val')
            ->andWhere('a.presentoire= tc.id')
            ->setParameter('val', $value)
            ->orderBy('a.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult();
        return $result;
    }

    public function findNomquartier($value)
    {
        $qb = $this->_em->createQueryBuilder();
        $result = $qb->select('tc.label')
            ->from('App\Entity\Client', 'a')
            ->innerJoin('App\Entity\Quartier', 'tc')
            ->andWhere('a.id = :val')
            ->andWhere('a.quartier= tc.id')
            ->setParameter('val', $value)
            ->orderBy('a.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult();
        return $result;
    }
    // Got 5 information d'adress from on id quartier
    //Make Back to relition up of it and got information
    public function findDeligationFromquartier()
    {
        $qb = $this->_em->createQueryBuilder();
        $result = $qb->select('tc.label')
            ->from('App\Entity\Quartier', 'a')
            ->innerJoin('App\Entity\Deligation', 'tc')
            ->andWhere('a.id = tc.id')
            ->andWhere('a.deligation= tc.id')
            // ->setParameter('val', $value)
            ->orderBy('a.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult();
        return $result;
    }

    public function findGouvernoratFromquartier()
    {
        $qb = $this->_em->createQueryBuilder();
        $result = $qb->select('tc.label')
            ->from('App\Entity\Deligation', 'a')
            ->innerJoin('App\Entity\Gouvernorat', 'tc')
            ->andWhere('a.id = tc.id')
            ->andWhere('a.gouvernorat= tc.id')
            // ->setParameter('val', $value)
            ->orderBy('a.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult();
        return $result;
    }

    public function findZoneFromquartier()
    {
        $qb = $this->_em->createQueryBuilder();
        $result = $qb->select('tc.label')
            ->from('App\Entity\Gouvernorat', 'a')
            ->innerJoin('App\Entity\Zone', 'tc')
            ->andWhere('a.id = tc.id')
            ->andWhere('a.zone= tc.id')
            // ->setParameter('val', $value)
            ->orderBy('a.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult();
        return $result;
    }

    public function findRegionFromquartier()
    {
        $qb = $this->_em->createQueryBuilder();
        $result = $qb->select('tc.label')
            ->from('App\Entity\Zone', 'a')
            ->innerJoin('App\Entity\Region', 'tc')
            ->andWhere('a.id = tc.id')
            // ->andWhere('a.zone= tc.id')
            // ->setParameter('val', $value)
            ->orderBy('a.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult();
        return $result;
    }

    //End 5
    public function findRegieTabac($value)
    {
        $qb = $this->_em->createQueryBuilder();
        $result = $qb->select('tc.label')
            ->from('App\Entity\Client', 'a')
            ->innerJoin('App\Entity\MarketingRegieTabac', 'tc')
            ->andWhere('a.id = :val')
            ->andWhere('a.regieTabac= tc.id')
            ->setParameter('val', $value)
            ->orderBy('a.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult();
        return $result;
    }

    public function findCompagneOncour($value)
    {
        $qb = $this->_em->createQueryBuilder();
        $result = $qb->select('tc.label')
            ->from('App\Entity\Client', 'a')
            ->innerJoin('App\Entity\MarketingCampagneEnCours', 'tc')
            ->andWhere('a.id = :val')
            ->andWhere('a.companieOncour= tc.id')
            ->setParameter('val', $value)
            ->orderBy('a.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult();
        return $result;
    }

    public function findRecette($value)
    {
        $qb = $this->_em->createQueryBuilder();
        $result = $qb->select('tc.recetteList')
            ->from('App\Entity\Client', 'a')
            ->innerJoin('App\Entity\MarketingRecette', 'tc')
            ->andWhere('a.id = :val')
            ->andWhere('a.recette= tc.id')
            ->setParameter('val', $value)
            ->orderBy('a.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult();
        return $result;
    }

    public function findProduit($value)
    {
        $qb = $this->_em->createQueryBuilder();
        $result = $qb->select('tc.id', 'tc.nom', 'tc.stokeMin', 'tc')
            ->from('App\Entity\Client', 'a')
            ->Join('App\Entity\Produit', 'tc')
            ->Join('App\Entity\Client', 'a')
            //->andWhere('a.id = :val')
            //->andWhere('a.produit= tc.id')
            ->setParameter('val', $value)
            //  ->orderBy('a.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult();
        return $result;
    }

    public function JTIid_stokeClient($value)
    {
        return $this->createQueryBuilder('c')
            ->leftJoin('c.stokes', 'st')
            ->select('st.id')
            ->andWhere('c.id =:val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getResult();
    }

    /**
     * @return Client[] Returns an array of Client objects
     */

    public function findProuitsByClient($value)
    {
        return $this->createQueryBuilder('c')
            ->innerJoin('c.produit ', 'p')
            ->select('p.id', 'p.nom', 'p.stoke')
            ->andWhere('c.id = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getResult();
    }

    public function findProuitsId($value)
    {
        return $this->createQueryBuilder('c')
            ->innerJoin('c.produit ', 'p')
            ->select('p.id')
            ->andWhere('c.id = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getResult();
    }

    // Mdifier info PDV Part

    public function findAlltypeDecideur()
    {
        $qb = $this->_em->createQueryBuilder();
        $result = $qb->select('tc.id', 'tc.type')
            ->from('App\Entity\TypeClient', 'tc')
            ->getQuery()
            ->getResult();
        return $result;
    }

    public function findCustom($value)
    {
        return $this->createQueryBuilder('c')
            ->select('c')
            ->andWhere('c.id = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getResult();
    }


    /**
     * @return Client[] Returns an array of Client objects
     */

    public function findClientTypes($value)
    {
        return $this->createQueryBuilder('c')
            ->leftJoin('c.infoClient', 'ic')
            ->leftJoin('ic.situationFamil', 'st')
            ->leftJoin('ic.AgeClient', 'ag')
            ->leftJoin('ic.nbrEnfant', 'nb')
            ->leftJoin('ic.typeClientNew', 'tp')
            ->select('ic.telephone', 'st.sitation', 'st.id as situation_id', 'ic.nom', 'ag.id as id_age', 'ag.age',
                'nb.nbrEnfant', 'nb.id as nbrEnfant_id ', 'tp.type', 'tp.id as type_id ', 'c.cin')
            ->andWhere('c.id = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getResult();
    }

    public function findClientInfo($value)
    {
        return $this->createQueryBuilder('c')
            ->leftJoin('c.decider', 'tp')
            ->select('c.id ', 'c.codeClient', 'c.licence', 'tp.type as Decideur')
            ->andWhere('c.id = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getResult();
    }

    public function findClientInfoPDV($value)
    {
        return $this->createQueryBuilder('c')
            ->leftJoin('c.quartier', 'qt')
            ->leftJoin('qt.deligation', 'dl')
            ->leftJoin('dl.gouvernorat', 'gv')
            ->leftJoin('gv.zone', 'zn')
            ->leftJoin('zn.region', 'rg')
            ->leftJoin('c.superficie', 'sup')
            ->leftJoin('c.nbrEmplyer', 'nbe')
            ->leftJoin('c.emplacement', 'emp')
            ->leftJoin('c.environnement', 'env')
            ->leftJoin('c.typeDeQuartier', 'typ')
            ->leftJoin('c.visibiliter', 'vis')
            ->leftJoin('c.classe', 'cls')
            ->leftJoin('c.typologie', 'typo')
            ->leftJoin('c.presentoire', 'pres')
            ->select('rg.label as region ', 'rg.id as region_id ', 'zn.label as zone ', 'zn.id as zone_id ',
                'gv.label as gouvernerat ', 'gv.id as gouvernerat_id ', 'dl.label as deligation ',
                'dl.id as deligation_id ',
                'qt.label as quartier ', 'qt.id as quartier_id ', 'c.adress as adresse', 'c.codePostal',
                'sup.label as superficie', 'sup.id as superficie_id', 'nbe.nbremployer', 'nbe.id as nbremployer_id ',
                'emp.label as emplacement',
                'emp.id as emplacement_id',
                'env.label as environnement', 'env.id as environnement_id', 'env.label as typeDeQuartier',
                'env.id as typeDeQuartier_id',
                'vis.label as visibiliter', 'vis.id as visibiliter_id', 'cls.label as classe', 'cls.id as classe_id',
                'typo.label as typologie', 'typo.id as typologie_id', 'c.infoAccPdv as accesAuPDV',
                'c.infoAccPdv as accesAuPDV_id',
                'pres.label as presentoire', 'pres.id as presentoire_id'
            )
            ->andWhere('c.id = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getResult();
    }

    public function tradMarketingPDV($value)
    {
        return $this->createQueryBuilder('c')
            ->leftJoin('c.regieTabac', 'rg')
            ->leftJoin('c.companieOncour', 'co')
            ->select('c.isOneToOne', 'rg.label', 'rg.id as regieTabac_id ', 'c.recetteP', 'c.recetteS'
                , 'c.isTlp', 'c.isFsPotentiel', 'co.label as CompagnieOnCour', 'co.id as CompagnieOnCour_id')
            ->andWhere('c.id = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getResult();
    }

    public function stokeMin($value)
    {
        return $this->createQueryBuilder('c')
            ->leftJoin('c.produit', 'pd')
            ->select('pd.id', 'pd.nom')
            ->andWhere('c.id = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getResult();
    }

    public function stokeMinNew($value)
    {
        return $this->createQueryBuilder('c')
            ->join('c.stokes', 's')
            ->join('c.produit', 'p')
            ->select('pd.id ')
            ->andWhere('c.id = :val')
            ->andWhere('c.produit = p.id')
            ->setParameter('val', $value)
            ->getQuery()
            ->getResult();
    }

    public function recette($value)
    {
        return $this->createQueryBuilder('c')
            ->leftJoin('c.recette', 'rc')
            ->select('rc.id as recette_id ', 'rc.recetteList as recette')
            ->andWhere('c.id = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getResult();
    }













    // /**
    //  * @return Client[] Returns an array of Client objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('c.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Client
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */


    /**
     * ic (infoClient) tc (TypeClient)
     * @return Client[] Returns an array of Client objects
     */

    public function customFindAll()
    {
        return $this->createQueryBuilder('c')
            ->leftJoin('c.infoClient', 'ic')
            ->leftJoin('ic.typeClientNew', 'tc')
            //->leftJoin('c.routings','r')
            ->select('c.id', 'c.codeClient',
                'c.licence', 'c.numLicence',
                'c.ville', 'c.nmbAffectation',
                'c.merchId', 'ic.nom as nom_titulaire')
            ->andWhere('c.draft = :zero')
            ->setParameter('zero', 0)
            ->andWhere('tc.type like :val')
            ->setParameter('val', 'Titulaire')
            ->orderBy('c.codeClient', 'ASC')
            //->distinct(true)
            ->getQuery()
            ->getResult();
    }

    /**
     * Find clients autocompleate
     * @return mixed
     */
    public function findClientsAutoComplete($code)
    {
        return $this->createQueryBuilder('c')
            ->leftJoin('c.infoClient', 'ic')
            ->leftJoin('ic.typeClientNew', 'tc')
            ->select('c.id', 'c.codeClient', 'ic.nom as nom_titulaire')
            ->andWhere('c.codeClient LIKE :code')
            ->setParameter('code', $code . '%')
            ->andWhere('c.draft = :zero')
            ->setParameter('zero', 0)
            ->andWhere('tc.type like :val')
            ->setParameter('val', 'Titulaire')
            ->orderBy('c.codeClient', 'ASC')
            ->getQuery()
            ->getResult();
    }

    /**
     * Find clients
     * @return mixed
     */
    public function findClientsStoke($value)
    {
        return $this->createQueryBuilder('c')
            ->leftJoin('c.stokeContainer', 'sc')
            ->leftJoin('sc.stoke', 'st')
            ->leftJoin('st.produit', 'p')
            ->select('p.id', 'p.nom', 'st.quantiter as stoke ')
            ->andWhere('c.id =:val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getResult();
    }


    /********************************** Filtrering *************************/
    /**
     * Test Filtrage client
     * @param array $arrayFiltrage
     * @return Client[] Returns an array of Client objects
     * @var $arrayFiltrage |null
     */
    public function customFindAllFilter($arrayFiltrage)
    {
        $query = $this->createQueryBuilder('c')
            ->leftJoin('c.infoClient', 'ic')
            ->leftJoin('ic.typeClientNew', 'tc')
            ->select('c.id', 'c.codeClient',
                'c.licence', 'c.numLicence',
                'c.ville', 'c.nmbAffectation',
                'c.merchId', 'ic.nom as nom_titulaire')
            ->andWhere('c.draft = :zero')
            ->setParameter('zero', 0)
            ->andWhere('tc.type like :val')
            ->setParameter('val', 'Titulaire')
            ->orderBy('c.codeClient', 'ASC');


        /*    if(!empty($arrayFiltrage)){
                if($arrayFiltrage["id"]){
                    $query = $query
                        //->andWhere($arrayFiltrage["label"][0].".id = :id")
                        ->andWhere("c.id = :id")
                        ->setParameter('id',$arrayFiltrage["id"]);
                }
            }*/

        if (!empty($arrayFiltrage)) {
            $ids = $arrayFiltrage["ids"];
            if (count($ids) > 0) {
                foreach ($ids as $key => $id) {
                    $query = $query
                        ->andWhere("c.id = :val")
                        ->setParameter("val", $id);
                }

            }
        }


        return $query->getQuery()->getResult();
    }


    /**
     * show all client with pagination
     * @return Query Returns an array of Client objects
     */

    public function customFindAllQuery()
    {
        return $this->createQueryBuilder('c')
            ->leftJoin('c.infoClient', 'ic')
            ->leftJoin('ic.typeClientNew', 'tc')
            // ->leftJoin('c.routings','r')
            ->select('c.id', 'c.codeClient', 'c.licence', 'c.numLicence', 'c.ville', 'c.nmbAffectation', 'c.merchId',
                'ic.nom as nom_titulaire')
            ->andWhere('c.draft = :zero')
            ->setParameter('zero', 0)
            ->andWhere('tc.type like :val')
            ->setParameter('val', 'Titulaire')
            ->orderBy('c.codeClient', 'ASC')
            ->getQuery();
    }

    /**
     * Function findAll Client With Pagination
     * @return Query
     */
    /* public function findAllQuery(){
         return $this->createQueryBuilder('c')
             ->select('c.id','c.codeClient','c.licence','c.numLicence')
             ->orderBy('c.id','ASC')
             ->getQuery()
             ;
     }*/


    /**
     * @return Client[] Returns an array of Client objects
     */

    public function findInfoClient($value)
    {
        return $this->createQueryBuilder('c')
            ->leftJoin('c.infoClient', 'ic')
            ->leftJoin('ic.typeClientNew', 'tc')
            ->select('ic.nom')
            ->andWhere('c.id = :val')
            ->setParameter('val', $value)
            ->andWhere('tc.type like :val2')
            ->setParameter('val2', 'Titulaire')
            ->getQuery()
            ->getResult();
    }


    /**
     * Function to find all routing id of client
     * @return Client[] Returns an array of Client objects
     */

    public function findAllRoutings($value)
    {
        return $this->createQueryBuilder('c')
            ->leftJoin('c.routings', 'r')
            ->select('r.id', 'CONCAT(r.classe,\'-\',r.codeRouting,\'-\',r.ville) AS code')
            ->andWhere('c.id = :val')
            ->setParameter('val', $value)
            ->distinct(true)
            ->getQuery()
            ->getResult();
    }

}
