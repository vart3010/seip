<?php

namespace Pequiven\SEIPBundle\Repository;

use Pequiven\SEIPBundle\Entity\User;
use Tecnocreaciones\Bundle\ResourceBundle\Doctrine\ORM\EntityRepository;

/**
 * Repositorio del usuario (pequiven_seip.repository.user)
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class UserRepository extends EntityRepository {

    /**
     * Retornar el query con los usuario a los cuales le puedo asignar programas de gestion tacticos
     * 
     * @return type
     */
    function findQueryToAssingTacticArrangementProgram($criteria = array()) {
        $criteria = new \Doctrine\Common\Collections\ArrayCollection($criteria);

        $qb = $this->getQueryBuilder();
        $user = $this->getUser();
        $level = $user->getLevelRealByGroup();

        $categoryArrangementProgramId = $criteria['categoryArrangementProgramId'];

        $qb
                ->innerJoin('u.groups', 'g')
                ->andWhere('g.typeRol = :typeRol')
                ->setParameter('typeRol', \Pequiven\MasterBundle\Entity\Rol::TYPE_ROL_OWNER)
        ;
        if ($categoryArrangementProgramId == \Pequiven\ArrangementProgramBundle\Entity\ArrangementProgram::ASSOCIATE_ARRANGEMENT_PROGRAM_PLA) {
            $qb
                    ->andWhere($qb->expr()->orX('g.level <= :level', 'u.id = :user'))
                    ->andWhere('g.level >= :minLevel')
                    ->setParameter('minLevel', \Pequiven\MasterBundle\Entity\Rol::ROLE_WORKER_PQV)
                    ->setParameter('user', $user)
            ;
            if ($level == \Pequiven\MasterBundle\Entity\Rol::ROLE_DIRECTIVE) {
                $qb
                        ->andWhere($qb->expr()->isNotNull('u.gerencia'))
                        ->andWhere("u.gerencia != ''")
                        ->setParameter('level', $level)
                ;
            } elseif ($this->getSecurityContext()->isGranted('ROLE_ARRANGEMENT_PROGRAM_EDIT') == true) {
                $qb->setParameter('level', \Pequiven\MasterBundle\Entity\Rol::ROLE_DIRECTIVE);
            } else {
                if ($this->getSecurityContext()->isGranted('ROLE_ARRANGEMENT_PROGRAM_EDIT') == false) {
                    $qb
                            ->andWhere('u.gerencia = :gerencia')
                            ->setParameter('gerencia', $user->getGerencia())
                            ->setParameter('level', $level)
                    ;
                }
            }
        }

        $orX = $qb->expr()->orX();
        if (($firstname = $criteria->remove('firstname'))) {
            $orX->add($qb->expr()->like('u.firstname', "'%" . $firstname . "%'"));
        }
        if (($lastname = $criteria->remove('lastname'))) {
            $orX->add($qb->expr()->like('u.lastname', "'%" . $lastname . "%'"));
        }
        if (($username = $criteria->remove('username'))) {
            $orX->add($qb->expr()->like('u.username', "'%" . $username . "%'"));
        }
        if (($numPersonal = $criteria->remove('numPersonal'))) {
            $orX->add($qb->expr()->like('u.numPersonal', "'%" . $numPersonal . "%'"));
        }
        if (($gerencia = $criteria->remove('gerencia'))) {
            $orX->add($qb->expr()->orX('u.gerenciaSecond = :gerencia'));
            $qb->setParameter('gerencia', $gerencia);
        }

        if ($categoryArrangementProgramId == \Pequiven\ArrangementProgramBundle\Entity\ArrangementProgram::ASSOCIATE_ARRANGEMENT_PROGRAM_PLA) {

            $qbUserConfiguration = $this->getQueryBuilder();

            $qbUserConfiguration
                    ->select('u.id')
                    ->innerJoin('u.configuration', 'u_c')
                    ->innerJoin('u_c.localizations', 'u_c_l')
                    ->innerJoin('u_c_l.gerencia', 'u_c_l_g')
                    ->andWhere('u_c_l_g.id = :gerencia')
                    ->setParameter('gerencia', $user->getGerencia())
            ;
            $resultUserConfiguration = $qbUserConfiguration->getQuery()->getResult();
            $idUsersConfiguration = array();
            foreach ($resultUserConfiguration as $value) {
                $idUsersConfiguration[$value['id']] = $value['id'];
            }
            if (count($idUsersConfiguration) > 0) {
                $qb->orWhere($qb->expr()->in('u.id', $idUsersConfiguration));
            }
        }

        $qb->andWhere($orX);

        $qb->setMaxResults(50);

        return $qb;
    }

    /**
     * Retornar los usuario a los cuales le puedo asignar programas de gestion tacticos
     * @return type
     */
    function findToAssingTacticArrangementProgram($criteria = array()) {
        return $this->findQueryToAssingTacticArrangementProgram($criteria)->getQuery()->getResult();
    }

    /**
     * Retornar los usuario a los cuales le puedo asignar metas de un programa de gestion tactico
     * @return type
     */
    function findQueryToAssingTacticArrangementProgramGoal(array $users, array $criteria = array()) {

        $criteria = new \Doctrine\Common\Collections\ArrayCollection($criteria);
        $categoryArrangementProgramId = $criteria['categoryArrangementProgramId'];
        $qb = $this->getQueryBuilder();

        $qb
                ->innerJoin('u.groups', 'g')
                ->andWhere('g.typeRol = :typeRol')
                ->setParameter('typeRol', \Pequiven\MasterBundle\Entity\Rol::TYPE_ROL_OWNER)
        ;

        if ($categoryArrangementProgramId == \Pequiven\ArrangementProgramBundle\Entity\ArrangementProgram::ASSOCIATE_ARRANGEMENT_PROGRAM_PLA) {
            $level = 0;
            $usersId = array();
            foreach ($users as $user) {
                if ($user->getLevelRealByGroup() > $level) {
                    $level = $user->getLevelRealByGroup();
                }
                $usersId[] = $user->getId();
            }
            $qb
                    ->andWhere($qb->expr()->orX('g.level <= :level', $qb->expr()->in('u.id', $usersId)))
                    //            ->andWhere('u.gerencia = :gerencia')
                    ->setParameter('level', $level)
            //            ->setParameter('gerencia', $user->getGerencia())
            ;
        }

        $orX = $qb->expr()->orX();
        if (($firstname = $criteria->remove('firstname'))) {
            $orX->add($qb->expr()->like('u.firstname', "'%" . $firstname . "%'"));
        }
        if (($lastname = $criteria->remove('lastname'))) {
            $orX->add($qb->expr()->like('u.lastname', "'%" . $lastname . "%'"));
        }
        if (($username = $criteria->remove('username'))) {
            $orX->add($qb->expr()->like('u.username', "'%" . $username . "%'"));
        }
        if (($numPersonal = $criteria->remove('numPersonal'))) {
            $orX->add($qb->expr()->like('u.numPersonal', "'%" . $numPersonal . "%'"));
        }
        if (($gerencia = $criteria->remove('gerencia'))) {
            $orX->add($qb->expr()->orX('u.gerenciaSecond = :gerencia'));
            $qb->setParameter('gerencia', $gerencia);
        }
        $qb->andWhere($orX);

        if ($gerencia == null) {
            $qb->setMaxResults(50);
        } else {
            $qb->setMaxResults(400);
        }
        return $qb;
    }

    /**
     * Retornar los usuario a los cuales le puedo asignar metas de un programa de gestion tactico
     * @return type
     */
    function findToAssingTacticArrangementProgramGoal(array $users = array(), array $criteria = array()) {
        return $this->findQueryToAssingTacticArrangementProgramGoal($users, $criteria)->getQuery()->getResult();
    }

    function findUsers(array $responsiblesId) {
        $qb = $this->getQueryBuilder();
        $qb
                ->addSelect('g')
                ->innerJoin('u.groups', 'g')
                ->andWhere($qb->expr()->in('u.id', $responsiblesId))
                ->andWhere('u.enabled = :enabled')
                ->setParameter('enabled', true)
        ;
        return $qb->getQuery()->getResult();
    }

    function findUsersByCriteria(array $criteria = array()) {
        return $this->findQueryUsersByCriteria($criteria)->getQuery()->getResult();
    }

    function findQueryUsersByCriteria(array $criteria = array()) {
        $qb = $this->getQueryBuilder();
        $qb
                ->addSelect('g')
                ->innerJoin('u.groups', 'g')
                ->andWhere('u.enabled = :enabled')
                ->andWhere('g.typeRol = :typeRol')
                ->setParameter('enabled', true)
                ->setParameter('typeRol', \Pequiven\MasterBundle\Entity\Rol::TYPE_ROL_OWNER)
        ;
        $qb
                ->andWhere('g.level <= :level')
                ->setParameter('level', \Pequiven\MasterBundle\Entity\Rol::ROLE_DIRECTIVE);
        return $qb;
    }

    /**
     * Buscador de usuarios
     * 
     * @param array $criteria
     * @return type
     */
    function searchUserByCriteria(array $criteria = array()) {
        $qb = $this->getQueryBuilder();
        $qb
                ->innerJoin('u.groups', 'g')
                ->andWhere('g.typeRol = :typeRol')
                ->andWhere('u.enabled = :enabled')
                ->andWhere('g.level <= :level')
                ->setParameter('enabled', true)
                ->setParameter('typeRol', \Pequiven\MasterBundle\Entity\Rol::TYPE_ROL_OWNER)
                ->setParameter('level', \Pequiven\MasterBundle\Entity\Rol::ROLE_DIRECTIVE);

        $criteria = new \Doctrine\Common\Collections\ArrayCollection($criteria);
        $orX = $qb->expr()->orX();
        if (($firstname = $criteria->remove('firstname'))) {
            $orX->add($qb->expr()->like('u.firstname', "'%" . $firstname . "%'"));
        }
        if (($lastname = $criteria->remove('lastname'))) {
            $orX->add($qb->expr()->like('u.lastname', "'%" . $lastname . "%'"));
        }
        if (($username = $criteria->remove('username'))) {
            $orX->add($qb->expr()->like('u.username', "'%" . $username . "%'"));
        }
        if (($numPersonal = $criteria->remove('numPersonal'))) {
            $orX->add($qb->expr()->like('u.numPersonal', "'%" . $numPersonal . "%'"));
        }
        $qb->andWhere($orX);

        $qb->setMaxResults(30);
        return $qb->getQuery()->getResult();
    }

    function searchUserByCriteriaUnder(array $criteria = array()) {
        $qb = $this->getQueryBuilder();
        $qb
                ->innerJoin('u.groups', 'g')
                ->andWhere('g.typeRol = :typeRol')
                ->andWhere('u.enabled = :enabled')
                ->setParameter('enabled', true)
                ->setParameter('typeRol', \Pequiven\MasterBundle\Entity\Rol::TYPE_ROL_OWNER)
        ;

        $criteria = new \Doctrine\Common\Collections\ArrayCollection($criteria);
        $orX = $qb->expr()->orX();
        if (($firstname = $criteria->remove('firstname'))) {
            $orX->add($qb->expr()->like('u.firstname', "'%" . $firstname . "%'"));
        }
        if (($lastname = $criteria->remove('lastname'))) {
            $orX->add($qb->expr()->like('u.lastname', "'%" . $lastname . "%'"));
        }
        if (($username = $criteria->remove('username'))) {
            $orX->add($qb->expr()->like('u.username', "'%" . $username . "%'"));
        }
        if (($numPersonal = $criteria->remove('numPersonal'))) {
            $orX->add($qb->expr()->like('u.numPersonal', "'%" . $numPersonal . "%'"));
        }
        $qb->andWhere($orX);
        if (($levelUser = $criteria->remove('levelUser'))) {
            $qb
                ->andWhere('g.level <= :level')
                ->setParameter('level', $levelUser);
            if (($idGerenciaUser = $criteria->remove('idGerenciaUser'))) {
                $qb
                    ->andWhere("u.gerencia = :gerenciaId")
                    ->setParameter("gerenciaId", $idGerenciaUser);
            }
            if (($idGerenciaSecondUser = $criteria->remove('idGerenciaSecondUser'))) {
                $qb
                    ->andWhere("u.gerenciaSecond = :gerenciaSecond ")
                    ->setParameter("gerenciaSecond", $idGerenciaSecondUser);
            }
        }

        $qb->setMaxResults(30);
        
        return $qb->getQuery()->getResult();
    }

    protected function applyCriteria(\Doctrine\ORM\QueryBuilder $queryBuilder, array $criteria = null) {
        $criteria = new \Doctrine\Common\Collections\ArrayCollection($criteria);

        if (($firstname = $criteria->remove('firstname'))) {
            $queryBuilder->andWhere($queryBuilder->expr()->like('u.firstname', "'%" . $firstname . "%'"));
        }
        if (($lastname = $criteria->remove('lastname'))) {
            $queryBuilder->andWhere($queryBuilder->expr()->like('u.lastname', "'%" . $lastname . "%'"));
        }
        if (($username = $criteria->remove('username'))) {
            $queryBuilder->andWhere($queryBuilder->expr()->like('u.username', "'%" . $username . "%'"));
        }
        if (($numPersonal = $criteria->remove('numPersonal'))) {
            $queryBuilder->andWhere($queryBuilder->expr()->like('u.numPersonal', "'%" . $numPersonal . "%'"));
        }

        return parent::applyCriteria($queryBuilder, $criteria->toArray());
    }

    /**
     * Crea un paginador para los usuarios
     * 
     * @param array $criteria
     * @param array $orderBy
     * @return QueryBuilder
     */
    function createPaginatorUser(array $criteria = null, array $orderBy = null) {
        $queryBuilder = $this->getCollectionQueryBuilder();
        $queryBuilder->leftJoin('u.groups', 'gr');
        $queryBuilder->leftJoin('u.complejo', 'c');
        $queryBuilder->leftJoin('u.gerencia', 'g');
        $queryBuilder->leftJoin('u.gerenciaSecond', 'gs');
        $queryBuilder->andWhere('gr.typeRol =:typeRol');
        $queryBuilder->setParameter('typeRol', 0);

        if (isset($criteria['firstname'])) {
            $queryBuilder->andWhere($queryBuilder->expr()->like('u.firstname', "'%" . $criteria['firstname'] . "%'"));
        }
        if (isset($criteria['lastname'])) {
            $queryBuilder->andWhere($queryBuilder->expr()->like('u.lastname', "'%" . $criteria['lastname'] . "%'"));
        }
        if (isset($criteria['username'])) {
            $queryBuilder->andWhere($queryBuilder->expr()->like('u.username', "'%" . $criteria['username'] . "%'"));
        }
        if (isset($criteria['numPersonal'])) {
            $queryBuilder->andWhere($queryBuilder->expr()->like('u.numPersonal', "'%" . $criteria['numPersonal'] . "%'"));
        }
        if (isset($criteria['complejo'])) {
            $queryBuilder->andWhere($queryBuilder->expr()->like('c.description', "'%" . $criteria['complejo'] . "%'"));
        }
        if (isset($criteria['gerencia'])) {
            $queryBuilder->andWhere($queryBuilder->expr()->like('g.description', "'%" . $criteria['gerencia'] . "%'"));
        }
        if (isset($criteria['gerenciaSecond'])) {
            $queryBuilder->andWhere($queryBuilder->expr()->like('gs.description', "'%" . $criteria['gerenciaSecond'] . "%'"));
        }
        if (isset($criteria['role'])) {
            $queryBuilder->andWhere($queryBuilder->expr()->like('gr.description', "'%" . $criteria['role'] . "%'"));
        }

        return $this->getPaginator($queryBuilder);
    }

    /**
     * Crea un paginador para los usuarios
     * 
     * @param array $criteria
     * @param array $orderBy
     * @return QueryBuilder
     */
    function createPaginatorUserAux(array $criteria = null, array $orderBy = null) {
        $queryBuilder = $this->getCollectionQueryBuilder();
        $queryBuilder->leftJoin('u.groups', 'gr');
        $queryBuilder->leftJoin('u.complejo', 'c');
        $queryBuilder->leftJoin('u.gerencia', 'g');
        $queryBuilder->leftJoin('u.gerenciaSecond', 'gs');
        $queryBuilder->andWhere('gr.typeRol =:typeRol');
        $queryBuilder->setParameter('typeRol', 1);

        if (isset($criteria['firstname'])) {
            $queryBuilder->andWhere($queryBuilder->expr()->like('u.firstname', "'%" . $criteria['firstname'] . "%'"));
        }
        if (isset($criteria['lastname'])) {
            $queryBuilder->andWhere($queryBuilder->expr()->like('u.lastname', "'%" . $criteria['lastname'] . "%'"));
        }
        if (isset($criteria['username'])) {
            $queryBuilder->andWhere($queryBuilder->expr()->like('u.username', "'%" . $criteria['username'] . "%'"));
        }
        if (isset($criteria['numPersonal'])) {
            $queryBuilder->andWhere($queryBuilder->expr()->like('u.numPersonal', "'%" . $criteria['numPersonal'] . "%'"));
        }
        if (isset($criteria['complejo'])) {
            $queryBuilder->andWhere($queryBuilder->expr()->like('c.description', "'%" . $criteria['complejo'] . "%'"));
        }
        if (isset($criteria['gerencia'])) {
            $queryBuilder->andWhere($queryBuilder->expr()->like('g.description', "'%" . $criteria['gerencia'] . "%'"));
        }
        if (isset($criteria['gerenciaSecond'])) {
            $queryBuilder->andWhere($queryBuilder->expr()->like('gs.description', "'%" . $criteria['gerenciaSecond'] . "%'"));
        }
        if (isset($criteria['role'])) {
            $queryBuilder->andWhere($queryBuilder->expr()->like('gr.description', "'%" . $criteria['role'] . "%'"));
        }

        return $this->getPaginator($queryBuilder);
    }

    function findUserByNumPersonal($numPersonal) {
        $qb = $this->getQueryBuilder();
        $qb
                ->andWhere('u.numPersonal = :numPersonal')
                ->innerJoin('u.groups', 'g')
                ->andWhere('g.typeRol = :typeRol')
                ->setParameter('typeRol', \Pequiven\MasterBundle\Entity\Rol::TYPE_ROL_OWNER)
                ->setParameter('numPersonal', $numPersonal)
        ;
        return $qb->getQuery()->getOneOrNullResult();
    }
    
    public function findQueryWithRoleOwner()
    {
        $qb = $this->getQueryBuilder();
        
        $qb
                ->innerJoin('u.groups', 'g')
                ->andWhere('g.typeRol = :typeRol')
                ->setParameter('typeRol', \Pequiven\MasterBundle\Entity\Rol::TYPE_ROL_OWNER)
        ;
        
        $qb
                ->andWhere('g.level <= :level')
                ->setParameter('level', \Pequiven\MasterBundle\Entity\Rol::ROLE_DIRECTIVE);
        
        return $qb;
    }

    protected function getAlias() {
        return 'u';
    }

}
