<?php

namespace App\Controller;

use App\Entity\Tag;
use Doctrine\ORM\QueryBuilder;
use App\Repository\TagRepository;
use Symfony\Component\Routing\Annotation\Route;
use EasyCorp\Bundle\EasyAdminBundle\Event\EasyAdminEvents;
use Symfony\Bundle\FrameworkBundle\Controller\ControllerTrait;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use EasyCorp\Bundle\EasyAdminBundle\Controller\EasyAdminController as BaseAdminController;
use Symfony\Component\Security\Core\Security;

class TagController extends BaseAdminController
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

    public function createListQueryBuilder($entityClass, $sortDirection, $sortField = null, $dqlFilter = null)
    {
        // add dqlFilter for the list of Tag of the logged user
        if (null === $dqlFilter) 
        {
            $dqlFilter = sprintf('entity.id = %s', $this->getUser()->getId());
        } 
        else 
        {
            $dqlFilter = sprintf('entity.id = %s', $this->getUser()->getId());
        }

        return $this->get('easyadmin.query_builder')->createListQueryBuilder($this->entity, $sortField, $sortDirection, $dqlFilter);
    }

    public function getUserId()
    {
        return $this->getUser()->getId();
    }

    public static function getTagsUser(TagRepository $repo): QueryBuilder
    {
        $controller = new TagController();

        //$repository = $this->getDoctrine()->getRepository(Tag::class);
        $user = $controller->getUserId();

        return $repo->createQueryBuilder('t')
                    ->where('t.user = :user')
                    ->setParameter('user', $user);

/*         $tags = $repo->findBy([
            'user' => $user
        ]);

        return $tags; */
    }
}
