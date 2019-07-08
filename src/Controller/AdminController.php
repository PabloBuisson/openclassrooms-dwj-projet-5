<?php

namespace App\Controller;

use App\Entity\Tag;
use App\Entity\Card;
use App\Repository\CardRepository;
use Symfony\Component\Routing\Annotation\Route;
use EasyCorp\Bundle\EasyAdminBundle\Event\EasyAdminEvents;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use EasyCorp\Bundle\EasyAdminBundle\Controller\EasyAdminController as BaseAdminController;

class AdminController extends BaseAdminController
{
     /**
     * Performs a database query to get all the records related to the given
     * entity. It supports pagination and field sorting.
     *
     * @param string      $entityClass
     * @param int         $page
     * @param int         $maxPerPage
     * @param string|null $sortField
     * @param string|null $sortDirection
     * @param string|null $dqlFilter
     *
     * @return Pagerfanta The paginated query results
     */
    public function findAll($entityClass, $page = 1, $maxPerPage = 15, $sortField = null, $sortDirection = null, $dqlFilter = null)
    {
        if (null === $sortDirection || !\in_array(\strtoupper($sortDirection), ['ASC', 'DESC'])) {
            $sortDirection = 'DESC';
        }
        $queryBuilder = $this->executeDynamicMethod('create<EntityName>ListQueryBuilder', [$entityClass, $sortDirection, $sortField, $dqlFilter]);
        $this->filterQueryBuilder($queryBuilder);
        $this->dispatch(EasyAdminEvents::POST_LIST_QUERY_BUILDER, [
            'query_builder' => $queryBuilder,
            'sort_field' => $sortField,
            'sort_direction' => $sortDirection,
        ]);
        return $this->get('easyadmin.paginator')->createOrmPaginator($queryBuilder, $page, $maxPerPage);
    }

    /**
     * Creates Query Builder instance for all the records.
     *
     * @param string      $entityClass
     * @param string      $sortDirection
     * @param string|null $sortField
     * @param string|null $dqlFilter
     *
     * @return QueryBuilder The Query Builder instance
     */
    public function createListQueryBuilder($entityClass, $sortDirection, $sortField = null, $dqlFilter = null)
    {
        // add dqlFilter that display elements of the logged user (elements of User had to be fetch in the new controller UserController)
        if (null === $dqlFilter)
        {
            $dqlFilter = sprintf('entity.user = %s', $this->getUser()->getId());
            //$dqlFilter .= sprintf(' AND entity.user_id = %s', $this->getUser()->getId());
        } 
        else 
        {
            $dqlFilter .= sprintf(' AND entity.user = %s', $this->getUser()->getId());
            //$dqlFilter .= sprintf(' AND entity.user_id = %s', $this->getUser()->getId());
        }
        
        return $this->get('easyadmin.query_builder')->createListQueryBuilder($this->entity, $sortField, $sortDirection, $dqlFilter);
    }
    
    // launched before the submission of the form that creates a new card
    public function createNewCardEntity(Tag $tag)
    {
        $user = $this->getUser();
        $tag->setUser($user);
        $card = new Card();
        $today = new \DateTime();
        $card->setDateCreation(new \DateTime())
             ->setDatePublication($today->setTime (00, 00, 00))
             ->setUser($user)
             ->addTag($tag);

        return $card;
    }

    // launched before the submission of the form that creates a new tag
    public function createNewTagEntity()
    {
        $tag = new Tag();
        $tag->setUser($this->getUser());

        return $tag;
    }

    // launched before the submission of the form that updates a new card
/*     public function updateCardEntity()
    {

    } */
}
