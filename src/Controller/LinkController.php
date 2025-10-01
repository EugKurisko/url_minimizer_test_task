<?php
namespace App\Controller;

use App\Service\LinkService;
use App\Repository\LinkRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use App\Dto\Request\LinkCreateRequest;

class LinkController extends AbstractController
{
    #[Route('/', name: 'link_form', methods: ['GET', 'POST'])]
    public function showForm(Request $request): Response
    {
        $shortUrl = $request->getSession()->getFlashBag()->get('shortUrl');

        return $this->render('link/index.html.twig', [
            'shortUrl' => $shortUrl[0] ?? null,
        ]);
    }

    #[Route('/create_link', name: 'link_create', methods: ['POST'])]
    public function create(Request $request, LinkService $linkService, ValidatorInterface $validator): Response
    {
        $dto = new LinkCreateRequest();
        $dto->url = $request->request->get('url');
        $dto->timeToLive = (int) $request->request->get('timeToLive');
        $errors = $validator->validate($dto);
        if (count($errors) > 0) {
            foreach ($errors as $error) {
                $this->addFlash('error', $error->getMessage());
            }
            return $this->redirectToRoute('link_form');
        }
        $url = $request->request->get('url');
        $timeToLive = (int)$request->request->get('timeToLive', 0);

        $link = $linkService->create($url, $timeToLive);
        $shortUrl = $this->generateUrl(
            'link_redirect',
            ['code' => $link->getShortCode()],
            UrlGeneratorInterface::ABSOLUTE_URL
        );

        $this->addFlash('shortUrl', $shortUrl);

        return $this->redirectToRoute('link_form');
    }

    #[Route('/s/{code}', name: 'link_redirect', methods: ['GET'])]
    public function redirectToOriginal(string $code, LinkRepository $repo): Response
    {
        $link = $repo->findOneBy(['shortCode' => $code]);

        if (!$link) {
            throw $this->createNotFoundException("Посилання не знайдено");
        }

        if ($link->isExpired()) {
            return new Response("Посилання прострочене", 410);
        }

        $link->incrementClicks();
        $repo->save($link);

        return $this->redirect($link->getOriginalUrl());
    }

    #[Route('/all_links', name: 'all_links', methods: ['GET'])]
    public function allLinks(LinkRepository $repo): Response
    {
        $links = $repo->findAll();

        return $this->render('link/list/links_list.html.twig', [
            'links' => $links,
        ]);
    }
}