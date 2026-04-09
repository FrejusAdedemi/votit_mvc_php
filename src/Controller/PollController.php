<?php
namespace App\Controller;

use App\Repository\PollRepository;
use App\Repository\PollItemRepository;
use App\Repository\UserPollItemRepository;
use App\Entity\Poll;
use App\Entity\PollItem;
use App\Entity\UserPollItem;

class PollController extends Controller {
    public function list() {
        $pollRepo = new PollRepository();
        $polls = $pollRepo->findAll();
        $this->render('poll/list', ['polls' => $polls]);
    }
    public function show() {
        $id = $_GET['id'] ?? null;
        if (!$id) {
            header('Location: /');
            exit;
        }
        $repo = new PollRepository();
        $poll = $repo->find($id);
        $itemRepo = new PollItemRepository();
        $items = $itemRepo->findByPollId($id);
        $voteRepo = new UserPollItemRepository();
        $results = $voteRepo->countVotes($id);
        $this->render('poll/show', ['poll' => $poll, 'items' => $items, 'results' => $results]);
    }
    public function create() {
        // Vérifier si l'utilisateur est connecté
        if (empty($_SESSION['user'])) {
            header('Location: /login');
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Récupérer les données du formulaire
            $title = trim($_POST['title'] ?? '');
            $description = trim($_POST['description'] ?? '');
            $categoryId = intval($_POST['category_id'] ?? 0);
            $optionsText = trim($_POST['options'] ?? '');

            // Valider les données
            if (empty($title) || empty($description) || $categoryId <= 0 || empty($optionsText)) {
                $this->render('poll/create', ['error' => 'Tous les champs sont requis.']);
                return;
            }

            // Parser les options (une par ligne)
            $options = array_filter(array_map('trim', explode("\n", $optionsText)));
            if (count($options) < 2) {
                $this->render('poll/create', ['error' => 'Vous devez fournir au moins 2 options.']);
                return;
            }

            // Créer le sondage
            $poll = new Poll(
                null,
                $title,
                $description,
                $_SESSION['user']->getId(),
                $categoryId
            );

            $pollRepo = new PollRepository();
            $poll = $pollRepo->create($poll);

            // Créer les items du sondage
            $itemRepo = new PollItemRepository();
            foreach ($options as $optionName) {
                $item = new PollItem(null, $optionName, $poll->getId());
                $itemRepo->create($item);
            }

            // Rediriger vers la page du sondage créé
            header('Location: /poll/?id=' . $poll->getId());
            exit;
        }

        // Afficher le formulaire pour une requête GET
        $this->render('poll/create');
    }
  
    public function vote() {
        // Vérifier si l'utilisateur est connecté
        if (empty($_SESSION['user'])) {
            header('Location: /login');
            exit;
        }

        // Récupérer l'ID du sondage
        $pollId = $_GET['id'] ?? null;
        if (!$pollId) {
            header('Location: /');
            exit;
        }

        // Vérifier que c'est une requête POST
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: /poll/?id=' . $pollId);
            exit;
        }

        // Récupérer le poll_item_id depuis le formulaire
        $pollItemId = $_POST['option'] ?? null;
        if (!$pollItemId) {
            header('Location: /poll/?id=' . $pollId);
            exit;
        }

        $userId = $_SESSION['user']->getId();

        // Supprimer les votes existants pour cet utilisateur et ce sondage
        $voteRepo = new UserPollItemRepository();
        $voteRepo->removeVotesForUserAndPoll($userId, $pollId);

        // Ajouter le nouveau vote
        $vote = new UserPollItem($userId, $pollItemId);
        $voteRepo->addVote($vote);

        // Rediriger vers la page du sondage
        header('Location: /poll/?id=' . $pollId);
        exit;
    }
}
