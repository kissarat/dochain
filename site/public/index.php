<?php
/**
 * Last modified: 18.07.10 10:53:24
 * Hash: f82b6f471a699e3a992536409d485e8e3dc515bd
 */

require_once '../web.php';
require_once '../src/Page.php';

$url = substr($_SERVER['REQUEST_URI'], 1);
/**
 * @var \Doctrine\ORM\EntityRepository $pageRepository
 * @var Page $page
 * @var Page $old
 */
$pageRepository = $entityManager->getRepository(Page::class);
$data = null;
$page = null;
$old = null;

switch ($_SERVER['REQUEST_METHOD']) {
    case 'GET':
        $page = new Page();
        $page->setUrl($url);
        $data = request('GET', $url);
        if ($data) {
            $page->setData($data);
            $old = $pageRepository->findOneBy(['hash' => $page->getHash()]);
            if (empty($old)) {
                $entityManager->persist($page);
            }
        }
        break;
}
$entityManager->flush();

if ($page instanceof Page && $data) {
    $id = $page->getId() ?: ($old ? $old->getId() : null);
    $isNew = $page->getId() > 0;
    http_response_code($isNew ? 201 : 200);
    $result = [
        'success' => true,
        'id' => $id,
        'hash' => $page->getHash()
    ];
} else {
    http_response_code(400);
    $result = [
        'success' => false
    ];
}

header('Content-Type: application/json; charset=utf-8');
echo json_encode($result, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
