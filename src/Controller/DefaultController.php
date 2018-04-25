<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="default")
     */
    public function index()
    {

	    $tracks = $this->get('App\Service\Playlist')->getTracks()->items;

	    shuffle($tracks);



	    $formatted = [];

	    $row = 0;
	    for ($i = 0; $i < 25; $i++ ) {
	    	if ($i % 5 == 0) {
	    		$row++;
		    }

		    $formatted[$row][] = [
		    	'name' => $tracks[$i]->track->name,
			    'artist' => $tracks[$i]->track->artists[0]->name
		    ];

	    }



        return $this->render('default/index.html.twig', [
        	'tracks' => $formatted,
            'controller_name' => 'DefaultController',
        ]);
    }
}
