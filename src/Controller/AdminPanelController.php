<?php

namespace App\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;


/**
 * @IsGranted("ROLE_ADMIN")
 */

class AdminPanelController extends AbstractController
{
    /**
     * @Route("/admin/panel", name="admin_panel")
     * @IsGranted("ROLE_ADMIN")

     */
    public function loadPanel()
    {

        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        return $this->render('admin_panel/index.html.twig', [

        ]);
    }
}
