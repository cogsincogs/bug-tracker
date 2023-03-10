<?php

include_once($_SERVER['DOCUMENT_ROOT'] . '/classes/userController.class.php');
include_once($_SERVER['DOCUMENT_ROOT'] . '/classes/orgController.class.php');
include_once($_SERVER['DOCUMENT_ROOT'] . '/classes/projController.class.php');

session_start();

$_SESSION['proj_id'] = '';
$_SESSION['ticket_id'] = '';

// Check if logged in
if (!isset($_SESSION["user_id"])) {
    header("Location: /login/");
}

$dbh = new UserController();
$user = $dbh->getUserByID($_SESSION["user_id"]);

$orgHandle = new OrgController();

if (isset($_GET['org_id'])) {
    $orgObj = $orgHandle->getOrganisationByID($_GET["org_id"]);
} else {
    header("Location: ../");
}

// If organisation ID is invalid or user tries to change URL
if (!$orgObj || $orgObj['ownerID'] !== $user['userID']) {
    header("Location: ../");
}

// Setting variables for use later on
$_SESSION['org_id'] = $orgObj['orgID'];
$orgName = $orgObj['name'];
$projHandle = new ProjController();
$projList = $projHandle->getProjects($orgObj['orgID']);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous" defer></script>
    <title>Organisation: <?= $orgName ?></title>
</head>
<body>
    <div class="container">
        <h1 class="display-1"><?= $orgName ?></h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/">Home</a></li>
                <li class="breadcrumb-item"><a href="/my/organisations/">Organisations</a></li>
                <li class="breadcrumb-item active" aria-current="page"><?= $orgName ?></li>
            </ol>
        </nav>
        <div class="card">
            <!-- If user has organisation(s) then display a list, otherwise display default -->
            <?php if (empty($projList)): ?>
                <h3 class="card-title display-3">Projects</h1>
                <div class="card-body">
                    <p class="card-text">A project allows you to manage your tickets. <a href="/create-project/">Create one now</a>.</p>
                </div>
            <?php else: ?>
                <h3 class="card-title display-3">My Projects</h1>
                <div class="card-body">
                    <ul>
                        <?php foreach ($projList as $proj): ?>
                            <li><a href="../project/?org_id=<?= htmlspecialchars($proj['orgID']) ?>&proj_id=<?= htmlspecialchars($proj['projID']) ?>"><?= htmlspecialchars($proj['name']) ?></a></li>
                        <?php endforeach; ?>
                    </ul>
                    <p class="card-text"><a href="/create-project/">Create another project</a>.</p>
                </div>
            <?php endif; ?>
        </div>
        <div>
            <p><a href="delete-organisation.php?org_id=<?= $orgObj['orgID'] ?>">Delete Organisation</a></p>
        </div>
    </div>
</body>
</html>