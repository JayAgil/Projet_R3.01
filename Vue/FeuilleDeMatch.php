<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Feuille de Match</title>
    <link rel="stylesheet" href="css/feuilleDeMatch.css">
</head>
<body>

<div class="container">
    <div class="left-panel">
        <h2>Joueurs actifs</h2>
        <table>
            <thead>
                <tr>
                    <th>Nom</th>
                    <th>Prénom</th>
                    <th>Taille</th>
                    <th>Poids</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($players as $p): ?>
                <tr>
                    <td><?= htmlspecialchars($p['Nom']) ?></td>
                    <td><?= htmlspecialchars($p['Prenom']) ?></td>
                    <td><?= htmlspecialchars($p['Taille_cm']) ?> cm</td>
                    <td><?= htmlspecialchars($p['Poids_kg']) ?> kg</td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <div class="right-panel">
        <h2>Feuille de match</h2>
        <form method="POST">
            
            <?php 
            $posMapping = ['PG' => 'Meneur (PG)', 'SG' => 'Arrière (SG)', 'SF' => 'Ailier (SF)', 'PF' => 'Ailier Fort (PF)', 'C' => 'Pivot (C)'];
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
                            <option value="<?= $p['NumeroLicence'] ?>" 
                                <?= ($savedSub && $savedSub['licence'] == $p['NumeroLicence']) ? 'selected' : '' ?>>
                                <?= htmlspecialchars($p['Nom'].' '.$p['Prenom']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div> 
                <?php endfor; ?>
            </div>

            <button type="submit" style="margin-top: 20px;">Enregistrer la feuille</button>
        </form>

        <?php if (!empty($error)) echo "<p style='color:red;'>$error</p>"; ?>
        <?php if (!empty($success)) echo "<p style='color:green;'>$success</p>"; ?>
    </div>
</div>

</body>
</html>