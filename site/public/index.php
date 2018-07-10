<?php
/**
 * Last modified: 18.07.10 10:00:40
 * Hash: 7a7c0dc5c261c7bd7d3ec2294958e69ec0cba1b0
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
            $old = $pageRepository->findBy(['hash' => $page->getHash()]);
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
