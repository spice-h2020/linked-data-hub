<?php
/**
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Application\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class IndexController extends AbstractActionController
{
    public function indexAction()
    {
        $streamRepository = $this->streamRepository();
        $docCounts = [
            'f9e601f0-06e6-4733-a791-ec42f3aab80e' => $streamRepository->getDocCount('f9e601f0-06e6-4733-a791-ec42f3aab80e')['totalDocs'],
            '7deccc71-46f5-46d3-9c83-9785aeec4f25' => $streamRepository->getDocCount('7deccc71-46f5-46d3-9c83-9785aeec4f25')['totalDocs'],
            'e377c7a6-47d5-42b9-8fc4-66d7476e46e5' => $streamRepository->getDocCount('e377c7a6-47d5-42b9-8fc4-66d7476e46e5')['totalDocs'],
            'd6a1d487-63bb-4eb4-993c-b707248aeca5' => $streamRepository->getDocCount('d6a1d487-63bb-4eb4-993c-b707248aeca5')['totalDocs'],
            '87801597-c115-4493-98b5-2e9a49864a10' => $streamRepository->getDocCount('87801597-c115-4493-98b5-2e9a49864a10')['totalDocs'],
            'a57c79a6-bed9-42e9-bc5d-c484c337045c' => $streamRepository->getDocCount('a57c79a6-bed9-42e9-bc5d-c484c337045c')['totalDocs'],
        ];
        $datasetRepository = $this->datasetRepository();
        $collectionsRepository = $this->datahubTopicsRepository();
        $datasets = $datasetRepository->findAllDatasets($this->currentUser()->getId(), "",3);
        $collections = $collectionsRepository->findAllCollections(3);
        $datasetCount = $datasetRepository->getDatasetCount();
        $collectionCount = $collectionsRepository->getCollectionCount();
        return new ViewModel([
            'spotlight' => [
                'docCounts'          => $docCounts,
                'datasets'          => $datasets,
                'collections'       => $collections,
                'datasetCount'      => $datasetCount,
                'collectionCount'   => $collectionCount
            ]
        ]);
    }
}
