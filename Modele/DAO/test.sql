select b.adresse as batiment,
       extract(year from p.date_paiement) as annee,
       sum(
          case
             when upper(p.designation_paiement) like '%PRIME%'
                 or upper(p.designation_paiement) like '%PROTECTION JURIDIQUE%' then
                p.montant
             else
                0
          end
       ) total,
       sum(
          case
             when upper(p.designation_paiement) like '%PRIME%' then
                p.montant
             else
                0
          end
       ) prime,
       sum(
          case
             when upper(p.designation_paiement) like '%PROTECTION JURIDIQUE%' then
                p.montant
             else
                0
          end
       ) protection_juridique
  from msf5131a.sae_batiment b,
       msf5131a.sae_bienlouable bl,
       msf5131a.sae_contratlocation cl,
       msf5131a.sae_paiement p
 where b.adresse = bl.fk_adresse_bat
   and bl.id_bienlouable = cl.fk_id_bienlouable
   and cl.numero_de_contrat = p.fk_numero_de_contrat
 group by b.adresse,
          extract(year from p.date_paiement)
having sum(
   case
      when upper(p.designation_paiement) like '%PRIME%'
          or upper(p.designation_paiement) like '%PROTECTION JURIDIQUE%' then
         p.montant
      else
         0
   end
) > 0
 order by annee desc,
          batiment;