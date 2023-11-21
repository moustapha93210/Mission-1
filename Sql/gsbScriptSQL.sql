SELECT v.id, v.nom, v.prenom, (lff.quantite * fraf.montant) AS 'MontantTotalCumulés'
FROM visiteur v INNER JOIN fichefrais ff ON ff.idVisiteur = v.id
INNER JOIN lignefraisforfait lff ON lff.idVisiteur = v.id AND lff.mois = ff.mois
INNER JOIN fraisforfait fraf ON fraf.id = lff.idFraisForfait
WHERE v.id = 'a131' AND ff.mois = '201903' AND lff.idFraisForfait = 'ETP';