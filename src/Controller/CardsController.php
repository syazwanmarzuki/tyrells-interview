<?php

namespace App\Controller;

use App\Controller\AppController;

class CardsController extends AppController
{
    public function initialize(): void
    {
        parent::initialize();
        $this->loadModel("User");
        $this->viewBuilder()->setHelpers(['General']);
    }

    public function index()
    {
    }

    public function distribute()
    {
        $validator = new \Cake\Validation\Validator();
        $validator
            ->requirePresence('numPeople')
            ->notEmpty('numPeople', 'We need the number of people.')
            ->numeric('numPeople', 'numbers only')
            ->range('numPeople', [1, 53], 'Between 1 and 53');

        $errors = $validator->errors($this->request->getData());
        if ($errors) {
            $this->Flash->error(__('Error!'));
        } else {
            $numPeople = $this->request->getData('numPeople');
            
            if ($numPeople < 1 || $numPeople > 53) {
                $result = 'Input value does not exist or value is invalid';
            } else {
               $cards = [];
               $suits = ['S', 'H', 'D', 'C'];
               $values = array_merge(range(2, 10), ['A', 'J', 'Q', 'K']);
               
               // Generate all 52 cards
               foreach ($suits as $suit) {
                   foreach ($values as $value) {
                       $cards[] = $suit . '-' . $value;
                   }
               }
               
               // Randomly shuffle the cards
               shuffle($cards); 
               
               $result = [];
               
               $cardsPerPerson = (int)(count($cards) / $numPeople);
               $residualCards = count($cards) % $numPeople;
               
               for ($i = 0; $i < $numPeople; $i++) {
               
                   // Get the number of cards for this player
                   $thisPlayerCardsNum = ($i < $residualCards) ? $cardsPerPerson + 1 : $cardsPerPerson;
               
                   // Get the cards for this player 
                   $playerCards = array_splice($cards, 0, $thisPlayerCardsNum);
                   
                   // Join the player's cards with commas and add to the result
                   $result[] = "Player " . ($i+1) . ": " . implode(',', $playerCards);
               }
               
               // separate each player's cards with an HTML <br> tag
               $response = [
                   'error' => false,
                   'payload' => implode('<br>', $result) 
               ];
            }
            

            $this->set(compact('result'));
            $this->viewBuilder()->setLayout('ajax');
            $this->autoRender = false;
            echo json_encode($response);
        }
    }
}
