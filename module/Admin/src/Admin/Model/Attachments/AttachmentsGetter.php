<?php

namespace Admin\Model\Attachments;

use Application\Model\QueryBuilderHelperAbstract;

/**
 * @author Andrea Fiori
 * @since  25 July 2014
 */
class AttachmentsGetter extends QueryBuilderHelperAbstract
{
    public function setMainQuery()
    {
        $this->setSelectQueryFields('DISTINCT(a.id) AS id, a.name, a.size, a.state, a.insertDate, 
                                      a.expireDate,
                                      ao.title, ao.description,
                                      u.name AS username, u.surname
                                    ');
        
        $this->getQueryBuilder()->select( $this->getSelectQueryFields() )
                                ->add('from', '
                                       Application\Entity\ZfcmsAttachments a, 
                                       Application\Entity\ZfcmsAttachmentsOptions ao, 
                                       Application\Entity\ZfcmsAttachmentsRelations ar,
                                       Application\Entity\ZfcmsUsers u
                                       ')
                                ->where(' ao.attachment = a.id AND ar.attachment = a.id AND a.user = u.id ');

        return $this->getQueryBuilder();
    }

    /**
     * @param number or array $id
     */
    public function setId($id)
    {
        if ( is_numeric($id) ) {
            $this->getQueryBuilder()->andWhere('a.id = :id ');
            $this->getQueryBuilder()->setParameter('id', $id);
        }
        
        if (is_array($id)) {
            $this->getQueryBuilder()->andWhere('a.id IN ( :id ) ');
            $this->getQueryBuilder()->setParameter('id', $id);
        }
        
        return $this->getQueryBuilder();
    }
    
    /**
     * @param number $moduleId
     */
    public function setModuleId($moduleId)
    {
        if ( is_numeric($moduleId) ) {
            $this->getQueryBuilder()->andWhere('ar.module = ( :moduleId ) ');
            $this->getQueryBuilder()->setParameter('moduleId', $moduleId);
        }
    }

    /**
     * @param number $referenceId
     */
    public function setReferenceId($referenceId)
    {
        if ( is_numeric($referenceId) ) {
            $this->getQueryBuilder()->andWhere('ar.referenceId = ( :referenceId ) ');
            $this->getQueryBuilder()->setParameter('referenceId', $referenceId);
        }
    }
    
    /**
     * @param number $attachmentId
     */
    public function setAttachmentId($attachmentId)
    {
        if ( is_numeric($attachmentId) ) {
            $this->getQueryBuilder()->andWhere('ar.attachment = ( :attachmentId ) ');
            $this->getQueryBuilder()->setParameter('attachmentId', $attachmentId);
        }
    }
}
