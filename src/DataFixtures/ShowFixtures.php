<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use App\Entity\Show;
use App\DataFixtures\LocationFixtures;

class ShowFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $fixtures = [
          [
              'slug'=>'ayiti',
              'title'=>'Ayiti',
              'description'=>"Un homme est bloqué à l’aéroport. Questionné par les douaniers, 
                  il doit alors justif ier son identité, et surtout prouver qu’il est haïtien 
                  – qu’est-ce qu’être haïtien ? Commence alors une leçon d’histoire singulière, 
                  un condensé de l’histoire d’Haïti qui donne à voir et à entendre le destin tragique 
                  de la première république noire. Contant, chantant, Daniel Marcelin incarne 
                  tour à tour les personnalités marquantes, des premiers habitants aux despotes comme 
                  Faustin Soulouque, Duvalier père et f ils, Aristide… Dans une scénographie toute 
                  simple, entouré de bagages divers, Daniel Marcelin occupe avec bonheur la scène de 
                  sa longue silhouette.",
              'poster_url'=>'images/ayiti.jpg',
              'location'=>'belfius-art-collection',
              'bookable'=>1,
              'price'=>9.50,
              'troupe'=>[
                  'bob-sull-comedien',
                  'marc-flynn-metteur-en-scene',
                  'fred-durand-comedien',
              ],
          ],
          [
              'slug'=>'cible-mouvante',
              'title'=>'Cible Mouvante',
              'description'=>"C’est un nouveau petit bijou que nous propose 
                Marius von Mayenburg. Une sorte de théâtre d’anticipation sociale 
                où de tout jeunes enfants sont suspectés d’être des poseurs de bombes. 
                Autour, des parents, des enquêteurs – on ne sait pas très bien – sont 
                rassemblés par l’angoisse, tous habités d’un sentiment de persécution 
                dans un monde en déréliction.",
              'poster_url'=>'images/cible.jpg',
              'location'=>'la-samaritaine',
              'bookable'=>1,
              'price'=>8.50,
              'troupe'=>[
                  'bob-sull-metteur-en-scene',
                  'marc-flynn-dramaturge',
                  'fred-durand-comedien',
              ],
          ],
          [
              'slug'=>'ceci-n-est-pas-un-chanteur-belge',
              'title'=>'Ceci n\'est pas un chanteur belge',
              'description'=>"Non peut-être ?!
                Entre Magritte (pour le surréalisme comique) et Maigret (pour le 
                réalisme mélancolique), ce dixième opus semalien propose quatorze 
                nouvelles chansons mêlées à de petits textes humoristiques et à 
                quelques fortes images poétiques. Mais c’est aussi une tendre méditation 
                sur la relation père - fils, puisque Semal « dialogue » en scène,
                pendant tout le spectacle, avec son fils de 4 ans. Les musiques et arrangements 
                de Frank Wuyts habillent ce seul-en-scène d’une trame musicale dense et bigarrée, 
                aussi efficace dans le minimalisme (l’Unplugged Protestsong Guy...",
              'poster_url'=>'images/claudebelgesaison220.jpg',
              'location'=>'belfius-art-collection',
              'bookable'=>0,
              'price'=>7.50,
              'troupe'=>[
                  'fred-durand-metteur-en-scene',
                  'marc-flynn-comedien',
              ],
          ],
        ];
        
        foreach($fixtures as $data) {
            $show = new Show();
            $show->setSlug($data['slug']);
            $show->setTitle($data['title']);
            $show->setDescription($data['description']);
            $show->setPosterUrl($data['poster_url']);
            $show->setLocation($this->getReference($data['location']));
            $show->setBookable($data['bookable']);
            $show->setPrice($data['price']);
            
            foreach ($data['troupe'] as $troupe) {
                $show->addTroupe($this->getReference($troupe));
            }
            
            $manager->persist($show);
            
            $this->addReference($data['slug'], $show);
        }

        $manager->flush();
    }

    public function getDependencies(): array {
        return [
            LocationFixtures::class,  
        ];
    }

}
