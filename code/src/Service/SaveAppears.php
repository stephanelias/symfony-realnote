<?php

namespace App\Service ;

use App\Entity\Album;
use App\Entity\Artist;
use App\Repository\ArtistRepository;
use App\Repository\TitleRepository;

class SaveAppears {

    public function execute(Album $album, ArtistRepository $artistRepository,TitleRepository $titleRepository) {
        $titles = $album->getTitles() ;
        for ( $i = 0 ; $i < $titles->count() ; $i++) {
            //$title = $titles->get($i) ;
            if (str_contains($titles->get($i)->getName(),"(feat.")) {
                $a = explode("(feat.",$titles->get($i)->getName()) ;
                $f = substr($a[1],1,-1);
                if (str_contains($f,",")) {
                    $f1 = str_replace(" ","",$f) ;
                    $f2 = explode(",",$f1) ;
                    for($j = 0 ; $j < count($f2) ; $j++) {
                        $res = $artistRepository->findOneBy([
                            'name' => $f2[$j]
                        ]) ;
                        if ( $res === null ) {
                            $artist = new Artist() ;
                            $artist->setName($f2[$j]);
                            $titles->get($i)->addFeat($artist) ;
                            $artist->addTitle($titles->get($i)) ;
                            $artistRepository->add($artist,true);
                        }
                        else {
                            $titles->get($i)->addFeat($artistRepository->findOneBy([
                                'name' => $f2[$j]
                            ])) ;
                            $titleRepository->add($titles->get($i),true);
                            $artistRepository->findOneBy([
                                'name' => $f2[$j]
                            ])->addTitle($titles->get($i)) ;
                            $artistRepository->add($artistRepository->findOneBy([
                                'name' => $f2[$j]
                            ]),true);
                        }
                    }
                }
                else {
                    $res = $artistRepository->findOneBy([
                        'name' => $f
                    ]) ;
                    if ( $res === null ) {
                        $artist = new Artist() ;
                        $artist->setName($f) ;
                        $titles->get($i)->addFeat($artist) ;
                        $artist->addTitle($titles->get($i)) ;
                        $artistRepository->add($artist,true);
                    }
                    else {
                        $titles->get($i)->addFeat($artistRepository->findOneBy([
                            'name' => $f
                        ])) ;
                        $titleRepository->add($titles->get($i),true);
                        $artistRepository->findOneBy([
                            'name' => $f
                        ])->addTitle($titles->get($i)) ;
                        $artistRepository->add($artistRepository->findOneBy([
                            'name' => $f
                        ]),true);
                    }
                }
            }
        }
    }
}
