<?php

namespace App\Service ;

use App\Entity\Album;
use App\Entity\Artist;
use App\Entity\Title;
use App\Repository\ArtistRepository;
use App\Repository\TitleRepository;
use function Symfony\Component\Translation\t;

class SaveAppears {

    public function execute(Album $album, ArtistRepository $artistRepository,TitleRepository $titleRepository) {
        $titles = $album->getTitles() ;
        for ( $i = 0 ; $i < $titles->count() ; $i++) {
            //$title = $titles->get($i) ;
            if (str_contains($titles->get($i)->getName(),"(feat.")) {
                $a = explode("(feat.",$titles->get($i)->getName()) ;
                $f = substr($a[1],1,-1);
                if (str_contains($f,",")) {
                    //$f1 = str_replace(" ","",$f) ;
                    $f2 = explode(",",$f);
                    for ($i = 0 ; $i < count($f2) ; $i++) {
                        if ($f2[$i][0] == " ") {
                            $f2[$i] = substr($f2[$i],1);
                        }
                        $res = $artistRepository->findOneBy([
                            'name' => $f2[$i]
                        ]) ;
                        if ( $res === null ) {
                            $artist = new Artist() ;
                            $artist->setName($f2[$i]);
                            $artist->addTitle($titles->get($i)) ;
                            $titles->get($i)->addFeat($artist) ;

                            $artistRepository->add($artist,true);
                        }
                        else {
                            $titles->get($i)->addFeat($res) ;
                            $titleRepository->add($titles->get($i),true);
                            $res->addTitle($titles->get($i)) ;
                            $artistRepository->add($res,true);
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
                        $titles->get($i)->addFeat($res) ;
                        $titleRepository->add($titles->get($i),true);
                        $res->addTitle($titles->get($i)) ;
                        $artistRepository->add($res,true);
                    }
                }
            }
        }
    }

    public function listFeats(string $titre) {
        if (str_contains($titre,"(feat.")) {
            $a = explode("(feat.", $titre);
            $f = substr($a[1], 1, -1);
            if (str_contains($f, ",")) {
                //$f1 = str_replace(" ","",$f) ;
                $f2 = explode(",", $f);
                for ($i = 0; $i < count($f2); $i++) {
                    if ($f2[$i][0] == " ") {
                        $f2[$i] = substr($f2[$i], 1);
                    }
                }
                return $f2 ;
            }
            $f1 = str_split($f,strlen($f)) ;
            return $f1;
        }

    }

    public function createNewIfDontExist(ArtistRepository $artistRepository,string $name) {
        if ($artistRepository->findOneBy(['name' => $name]) == null ) {
            $artist = new Artist() ;
            $artist->setName($name) ;
            $artistRepository->add($artist,true);
        }

    }

    public function putFeatInTitle(TitleRepository $titleRepository, Title $title, ArtistRepository $artistRepository,Artist $artist) {
        $title->addFeat($artist) ;
        $artist->addTitle($title) ;
        $artistRepository->add($artist,true);
        $titleRepository->add($title,true);
    }

    public function exec(Album $album, ArtistRepository $artistRepository,TitleRepository $titleRepository) {
        $titles = $album->getTitles() ;
        for ( $i = 0 ; $i < $titles->count() ; $i++) {
            $list = $this->listFeats($titles->get($i)->getName()) ;
            for ($j = 0 ; $j < count($list) ; $j++) {
                $this->createNewIfDontExist($artistRepository,$list[$j]);
            }
            for ($k = 0 ; $k < count($list) ; $k++) {
                $this->putFeatInTitle($titleRepository,$titles->get($i),$artistRepository,$artistRepository->findOneBy(['name' => $list[$k]]));
            }
        }
    }


}
