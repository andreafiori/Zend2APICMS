<?php

namespace Admin\Model\Posts;

use Application\Model\QueryBuilderHelperAbstract;
use Application\Model\Slugifier;

class PostsGetter extends QueryBuilderHelperAbstract
{
    /**
     * @return \Doctrine\ORM\QueryBuilder
     */
    public function setMainQuery()
    {
        $this->setSelectQueryFields('DISTINCT(p.id) AS id, p.lastUpdate,
                                    p.createDate, p.expireDate, p.hasAttachments,
                                    p.title, p.subtitle, p.description, p.slug, p.seoTitle,
                                    p.seoDescription, p.seoKeywords,

                                    c.name AS categoryName,
                                    c.templateFile, IDENTITY(r.module) AS moduleId, c.slug AS categorySlug,

                                    users.name AS userName, users.surname AS userSurname
                                    ');

        $this->getQueryBuilder()->select( $this->getSelectQueryFields() )
                                ->add('from', 'Application\Entity\ZfcmsPosts p,
                                                Application\Entity\ZfcmsPostsRelations r,

                                                Application\Entity\ZfcmsPostsCategories c,

                                                Application\Entity\ZfcmsModules module,

                                                Application\Entity\ZfcmsUsers users
                                        ')
                                ->where('p.id = r.posts AND c.id = r.category
                                        AND r.channel = :channel
                                        AND c.language = :language
                                        AND r.module = module.id
                                        AND p.user = users.id
                                        ');

        return $this->getQueryBuilder();
    }

    /**
     * @param int|null $channel
     * @return \Doctrine\ORM\QueryBuilder
     */
    public function setChannelId($channel = null)
    {
        if ( is_numeric($channel) ) {
            $this->getQueryBuilder()->setParameter('channel', $channel);
        }

        return $this->getQueryBuilder();
    }

    /**
     * @param number $languageId
     * @return \Doctrine\ORM\QueryBuilder
     */
    public function setLanguageId($languageId = null)
    {
        if (is_numeric($languageId)) {
            $this->getQueryBuilder()->setParameter('language', $languageId);
        }

        return $this->getQueryBuilder();
    }

    /**
     * @param number|array $id
     * @return \Doctrine\ORM\QueryBuilder
     */
    public function setId($id)
    {
        if ( is_numeric($id) ) {
            $this->getQueryBuilder()->andWhere('p.id = :id ');
            $this->getQueryBuilder()->setParameter('id', $id);
        }

        if (is_array($id)) {
            $this->getQueryBuilder()->andWhere('p.id IN ( :id ) ');
            $this->getQueryBuilder()->setParameter('id', $id);
        }

        return $this->getQueryBuilder();
    }

    /**
     * @param string $categorySlug
     * @return \Doctrine\ORM\QueryBuilder
     */
    public function setCategorySlug($categorySlug)
    {
        if ( is_string($categorySlug) ) {
            $this->getQueryBuilder()->andWhere('c.slug = :categorySlug ');
            $this->getQueryBuilder()->setParameter('categorySlug', $categorySlug);
        }

        return $this->getQueryBuilder();
    }

    /**
     * @param string $slug
     * @return \Doctrine\ORM\QueryBuilder
     */
    public function setSlug($slug)
    {
        if ( is_string($slug) ) {
            $this->getQueryBuilder()->andWhere('p.slug = :slug ');
            $this->getQueryBuilder()->setParameter('slug', $slug);
        }

        return $this->getQueryBuilder();
    }

    /**
     * @param string $title post title
     * @return \Doctrine\ORM\QueryBuilder
     */
    public function setTitle($title)
    {
        if ( is_string($title) ) {
            $this->getQueryBuilder()->andWhere('LOWER( p.seoTitle ) =  :title ');
            $this->getQueryBuilder()->setParameter('title', Slugifier::deSlugify($title) );
        }

        return $this->getQueryBuilder();
    }

    /**
     * @param string|array $type post type (content, blog, photo or video)
     * @return \Doctrine\ORM\QueryBuilder
     */
    public function setType($type)
    {
        if ( is_string($type) ) {
            $this->getQueryBuilder()->andWhere('p.type = :postType');
            $this->getQueryBuilder()->setParameter('postType', Slugifier::deSlugify($type) );
        } elseif ( is_array($type) ) {
            $this->getQueryBuilder()->andWhere( $this->getQueryBuilder()->expr()->in('p.type', $type));
        }

        return $this->getQueryBuilder();
    }

    /**
     * @param string|null $status
     * @return \Doctrine\ORM\QueryBuilder
     */
    public function setStatus($status = null)
    {
        if ($status == 'NULL' or $status == 'null') {
            $this->getQueryBuilder()->andWhere('p.status IS NULL ');
        } elseif ($status != null) {
            $this->getQueryBuilder()->andWhere("p.status = :status ");
            $this->getQueryBuilder()->setParameter('status', $status);
        }

        return $this->getQueryBuilder();
    }

    /**
     * @param string $moduleCode
     * @return \Doctrine\ORM\QueryBuilder
     */
    public function setModuleCode($moduleCode)
    {
        if ( is_string($moduleCode) ) {
            $this->getQueryBuilder()->andWhere('module.code =  :moduleCode ');
            $this->getQueryBuilder()->setParameter('moduleCode', $moduleCode);
        }

        return $this->getQueryBuilder();
    }


    /**
     * @param int $noScaduti
     * @return \Doctrine\ORM\QueryBuilder
     */
    public function setNoScaduti($noScaduti)
    {
        if ($noScaduti == 1) {
            $this->getQueryBuilder()->andWhere("( p.expireDate > '".date("Y-m-d H:i:s")."'
            OR p.dataScadenza = '0000-00-00 00:00:00' ) ");
        }

        return $this->getQueryBuilder();
    }
}
