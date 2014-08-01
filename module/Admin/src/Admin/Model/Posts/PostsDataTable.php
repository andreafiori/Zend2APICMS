<?php

namespace Admin\Model\Posts;

use Admin\Model\DataTable\DataTableAbstract;
use Admin\Model\Posts\PostsGetter;
use Admin\Model\Posts\PostsGetterWrapper;

/**
 * @author Andrea Fiori
 * @since  18 May 2014
 */
class PostsDataTable extends DataTableAbstract
{
    private $type;
    
    /**
     * @param array $input
     */
    public function __construct(array $input)
    {
        parent::__construct($input);
        
        $param = $this->getInput('param', 1);
        $this->type = $param['route']['option'];
        
        switch($this->type) {
            default: case("contenuto"):
                $this->title        = 'Contenuti';
                $this->description  = 'Gestione contenuti in archivio';
                $this->type         = 'content';
            break;

            case("blog"):
                $this->title        = 'Blog posts';
                $this->description  = 'Gestione posts in archivio';
                $this->type         = 'blog';
            break;

            case("foto"):
                $this->title        = 'Foto';
                $this->description  = 'Gestione foto in archivio';
                $this->type         = 'foto';
            break;
        }
    }
    
    /**
     * @return array 
     */
    public function getColumns()
    {
        return array("Titolo", "Inserito il", "Ultima modifica", "Stato", "&nbsp;", "&nbsp;", "&nbsp;");
    }
    
    /**
     * @return array 
     */
    public function getRecords()
    {
        $records = $this->getPostsRecords();
        
        $recordsToReturn = array();
        foreach($records as $record) {
            $recordsToReturn[] = array(
                $record['title'],
                $this->convertDateTimeToString($record['insertDate']),
                $this->convertDateTimeToString($record['lastUpdate']),
                ucfirst($record['status']),
                array(
                    'type'      => 'updateButton',
                    'href'      => $this->getInput('baseUrl',1).'formdata/posts/'.$record['postid'],
                    'tooltip'   => 1,
                    'title'     => 'Modifica'
                ),
                array(
                    'type'      => 'deleteButton',
                    'tooltip'   => 1,
                    'title'     => 'Elimina',
                    'data-id'   => $record['postoptionid']
                ),
                array(
                    'type'      => 'attachButton',
                    'href'      => '#',
                    'tooltip'   => 1,
                ),
            );
        }

        return $recordsToReturn;
    }
    
        /**
         * @return array
         */
        private function getPostsRecords()
        {
            $postsGetterWrapper = new PostsGetterWrapper( new PostsGetter($this->getInput('entityManager')) );
            $postsGetterWrapper->setInput( array("type" => $this->type) );
            $postsGetterWrapper->setupQueryBuilder();

            return $postsGetterWrapper->getRecords();
        }
}
