<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Feuille de Match</title>
    <link rel="stylesheet" href="css/feuilleDeMatch.css">
</head>
<body>

<!-- Afficher les informations du match -->
<div class="match-info">
    <p><strong>Adversaire:</strong> <?= htmlspecialchars($matchInfo['NomEquipeAdversaire']) ?></p>
    <p><strong>Date / Heure:</strong> <?= htmlspecialchars($matchInfo['DateDeMatch']) ?> <?= htmlspecialchars($matchInfo['HeureDeMatch']) ?></p>
    <p><strong>Lieu:</strong> <?= htmlspecialchars($matchInfo['LieuDeRencontre']) ?></p>
</div>

<div class="container">
    <!-- Afficher les joueurs actifs sous forme d'un tableau -->
    <div class="left-panel">
        <h2>Joueurs actifs</h2>
        <table>
            <thead>
                <tr>
                    <th>Nom</th>
                    <th>Prénom</th>
                    <th>Taille</th>
                    <th>Poids</th>
                    <th>Commentaire</th>
                    <th>Dernière note</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($players as $p): ?>
                    <tr>
                        <td><?= htmlspecialchars($p['Nom']) ?></td>
                        <td><?= htmlspecialchars($p['Prenom']) ?></td>
                        <td><?= htmlspecialchars($p['Taille_cm']) ?> cm</td>
                        <td><?= htmlspecialchars($p['Poids_kg']) ?> kg</td>
                        <td><?= htmlspecialchars($p['Commentaire']) ?></td>
                        <td><?= htmlspecialchars($lastNotes[$p['NumeroLicence']] ?? '-') ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <!-- Permettre de sélectionner les titulaires et les remplaçants -->
    <div class="right-panel">
        <h2>Feuille de match</h2>
        <form method="POST">
            <?php 
                $posMapping = [
                    'PG' => 'Meneur (PG)', 
                    'SG' => 'Arrière (SG)', 
                    'SF' => 'Ailier (SF)', 
                    'PF' => 'Ailier Fort (PF)', 
                    'C'  => 'Pivot (C)'
                ];
                foreach($posMapping as $code => $name): 
                    $savedLicence = $currentSelection['titulars'][$code] ?? ''; 
            ?>
                <div class="position-group">
                    <label><?= $name ?></label>
                    <select name="titular_<?= $code ?>" required>
                        <option value="">Choisir Joueur</option>
                        <?php foreach($players as $p): ?>
                            <option value="<?= $p['NumeroLicence'] ?>" <?= ($p['NumeroLicence'] == $savedLicence) ? 'selected' : '' ?>>
                                <?= htmlspecialchars($p['Nom'].' '.$p['Prenom']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
            <?php endforeach; ?>

            <hr>

            <h3>Remplaçants</h3>
            <div class="substitutes-grid">
                <?php for($i=0; $i < 7; $i++): 
                    $savedSub = $currentSelection['subs'][$i] ?? null;
                ?>
                    <div class="sub-entry"> 
                        <select name="sub_target_pos[]">
                            <option value="">Poste ciblé...</option>
                            <?php 
                                $codes = ['PG', 'SG', 'SF', 'PF', 'C'];
                                foreach($codes as $code): 
                                    $selected = ($savedSub && trim($savedSub['pos']) === $code) ? 'selected' : '';
                            ?>
                                <option value="<?= $code ?>" <?= $selected ?>><?= $code ?></option>
                            <?php endforeach; ?>
                        </select>

                        <select name="substitute_player[]">
                            <option value="">-- Choisir Remplaçant --</option>
                            <?php foreach($players as $p): ?>
                                <option value="<?= $p['NumeroLicence'] ?>" <?= ($savedSub && $savedSub['licence'] == $p['NumeroLicence']) ? 'selected' : '' ?>>
                                    <?= htmlspecialchars($p['Nom'].' '.$p['Prenom']) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div> 
                <?php endfor; ?>
            </div>

            <!-- Les boutons pour retourner au page principale ou enregistrer la feuille du match -->
            <div class="form-buttons">
                <a href="index.php?action=principale" class="btn-back">Retour</a>
                <button type="submit" class="btn-save">Enregistrer la feuille</button>
            </div>
        </form>

        <!-- Affichage du message erreur ou succès -->
        <?php if (!empty($error)) echo "<p style='color:red;'>$error</p>"; ?>
        <?php if (!empty($success)) echo "<p style='color:green;'>$success</p>"; ?>
    </div>
</div>

</body>
</html>
