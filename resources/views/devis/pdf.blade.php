<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<style>
    * { margin: 0; padding: 0; box-sizing: border-box; }
    body { font-family: DejaVu Sans, sans-serif; font-size: 11px; color: #1a202c; background: #fff; }

    /* ── HEADER ── */
    .header { background: #1e40af; color: #fff; padding: 28px 36px; }
    .header-inner { display: flex; justify-content: space-between; align-items: center; }
    .logo { font-size: 26px; font-weight: 700; letter-spacing: -0.5px; }
    .logo span { color: #fbbf24; }
    .header-right { text-align: right; font-size: 10px; opacity: 0.85; }
    .header-right strong { font-size: 13px; opacity: 1; display: block; margin-bottom: 2px; }

    /* ── DEVIS BADGE ── */
    .devis-title-block { background: #eff6ff; border-left: 4px solid #1e40af; margin: 24px 36px 0; padding: 14px 20px; }
    .devis-title-block h1 { font-size: 18px; color: #1e40af; font-weight: 700; }
    .devis-meta { margin-top: 6px; font-size: 10px; color: #4b5563; }
    .devis-meta span { margin-right: 24px; }
    .devis-meta strong { color: #1a202c; }

    /* ── TWO COLUMNS ── */
    .two-col { display: flex; gap: 20px; margin: 20px 36px 0; }
    .col { flex: 1; }
    .section-title { font-size: 10px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.8px;
        color: #6b7280; border-bottom: 1px solid #e5e7eb; padding-bottom: 6px; margin-bottom: 10px; }

    .info-block { background: #f9fafb; border: 1px solid #e5e7eb; border-radius: 6px; padding: 14px 16px; }
    .info-row { display: flex; margin-bottom: 6px; font-size: 11px; }
    .info-label { width: 90px; color: #6b7280; flex-shrink: 0; }
    .info-value { color: #111827; font-weight: 500; }

    /* ── CAR HEADER ── */
    .car-header { margin: 20px 36px 0; background: linear-gradient(135deg, #1e40af 0%, #3b82f6 100%);
        border-radius: 8px; padding: 20px 24px; color: #fff; display: flex; justify-content: space-between; align-items: center; }
    .car-name { font-size: 20px; font-weight: 700; }
    .car-sub { font-size: 11px; opacity: 0.8; margin-top: 4px; }
    .car-price-block { text-align: right; }
    .car-price-label { font-size: 10px; opacity: 0.8; }
    .car-price { font-size: 26px; font-weight: 700; color: #fbbf24; }
    .car-price-note { font-size: 9px; opacity: 0.7; margin-top: 2px; }

    /* ── TECH TABLE ── */
    .tech-table { width: 100%; border-collapse: collapse; margin: 16px 0; }
    .tech-table tr:nth-child(even) td { background: #f9fafb; }
    .tech-table td { padding: 7px 10px; border-bottom: 1px solid #e5e7eb; font-size: 10.5px; }
    .tech-table td:first-child { color: #6b7280; width: 160px; }
    .tech-table td:last-child { font-weight: 500; color: #111827; }

    /* ── EQUIPMENT ── */
    .equip-grid { display: flex; flex-wrap: wrap; gap: 6px; margin-top: 10px; }
    .equip-tag { background: #dbeafe; color: #1e40af; border-radius: 20px;
        padding: 3px 10px; font-size: 9.5px; font-weight: 500; }

    /* ── MESSAGE ── */
    .message-box { background: #fefce8; border: 1px solid #fde68a; border-radius: 6px; padding: 12px 14px;
        font-size: 10.5px; color: #78350f; font-style: italic; margin: 16px 36px 0; }

    /* ── VALIDITY ── */
    .validity-bar { background: #d1fae5; border: 1px solid #6ee7b7; border-radius: 6px; padding: 10px 14px;
        font-size: 10px; color: #065f46; margin: 16px 36px 0; text-align: center; }

    /* ── FOOTER ── */
    .footer { margin-top: 30px; padding: 16px 36px; border-top: 1px solid #e5e7eb;
        display: flex; justify-content: space-between; font-size: 9px; color: #9ca3af; }

    .section-wrap { margin: 16px 36px 0; }
</style>
</head>
<body>

{{-- HEADER --}}
<div class="header">
    <div class="header-inner">
        <div class="logo">Auto<span>Moto</span></div>
        <div class="header-right">
            <strong>DEVIS COMMERCIAL</strong>
            La plateforme automobile N°1
        </div>
    </div>
</div>

{{-- DEVIS NUMBER + DATE --}}
<div class="devis-title-block">
    <h1>Demande de Devis</h1>
    <div class="devis-meta">
        <span>N° <strong>{{ $numero }}</strong></span>
        <span>Date : <strong>{{ $date }}</strong></span>
        <span>Valable jusqu'au : <strong>{{ $validite }}</strong></span>
    </div>
</div>

{{-- CLIENT + SELLER COLUMNS --}}
<div class="two-col">
    <div class="col">
        <div class="section-title">Informations Client</div>
        <div class="info-block">
            <div class="info-row"><span class="info-label">Nom :</span><span class="info-value">{{ $client['prenom'] }} {{ $client['nom'] }}</span></div>
            <div class="info-row"><span class="info-label">Email :</span><span class="info-value">{{ $client['email'] }}</span></div>
            <div class="info-row"><span class="info-label">Téléphone :</span><span class="info-value">{{ $client['telephone'] }}</span></div>
        </div>
    </div>
    <div class="col">
        <div class="section-title">Établi par</div>
        <div class="info-block">
            <div class="info-row"><span class="info-label">Société :</span><span class="info-value">AutoMoto</span></div>
            <div class="info-row"><span class="info-label">Contact :</span><span class="info-value">contact@momtez.tn</span></div>
            <div class="info-row"><span class="info-label">Téléphone :</span><span class="info-value">+216 99 910 672</span></div>
        </div>
    </div>
</div>

{{-- CAR HEADER --}}
<div class="car-header">
    <div>
        <div class="car-name">{{ $marque->nom }} {{ $vehicule->modele }}</div>
        <div class="car-sub">{{ $vehicule->annee }} · {{ $vehicule->carburant }} · {{ $vehicule->transmission }}</div>
    </div>
    <div class="car-price-block">
        <div class="car-price-label">Prix à partir de</div>
        <div class="car-price">{{ number_format($vehicule->prix, 0, ',', ' ') }} €</div>
        <div class="car-price-note">Prix TTC — Hors options</div>
    </div>
</div>

{{-- FICHE TECHNIQUE --}}
<div class="section-wrap">
    <div class="section-title">Fiche Technique</div>
    <table class="tech-table">
        <tr><td>Marque</td><td>{{ $marque->nom }}</td></tr>
        <tr><td>Modèle</td><td>{{ $vehicule->modele }}</td></tr>
        <tr><td>Année</td><td>{{ $vehicule->annee }}</td></tr>
        <tr><td>Carburant</td><td>{{ $vehicule->carburant }}</td></tr>
        <tr><td>Puissance</td><td>{{ $vehicule->puissance }} ch</td></tr>
        <tr><td>Couple</td><td>{{ $vehicule->couple }} Nm</td></tr>
        <tr><td>Transmission</td><td>{{ $vehicule->transmission }}</td></tr>
        <tr><td>Consommation</td><td>{{ $vehicule->consommation }} L/100km</td></tr>
        <tr><td>Nb de portes</td><td>{{ $vehicule->nb_portes }}</td></tr>
        <tr><td>Nb de places</td><td>{{ $vehicule->nb_places }}</td></tr>
        <tr><td>Volume du coffre</td><td>{{ $vehicule->volume_coffre }} L</td></tr>
        <tr><td>Couleur</td><td>{{ $vehicule->couleur }}</td></tr>
        <tr><td>Kilométrage</td><td>{{ number_format($vehicule->kilometrage, 0, ',', ' ') }} km</td></tr>
        <tr><td>Garantie</td><td>{{ $vehicule->garantie }} ans</td></tr>
    </table>
</div>

{{-- EQUIPEMENTS --}}
@if($vehicule->equipements && count($vehicule->equipements) > 0)
<div class="section-wrap">
    <div class="section-title">Équipements & Options Inclus</div>
    <div class="equip-grid">
        @foreach($vehicule->equipements as $equip)
            <span class="equip-tag">✓ {{ $equip }}</span>
        @endforeach
    </div>
</div>
@endif

{{-- MESSAGE CLIENT --}}
@if(!empty($client['message']))
<div class="message-box">
    <strong>Message du client :</strong> {{ $client['message'] }}
</div>
@endif

{{-- VALIDITY --}}
<div class="validity-bar">
    ✓ Ce devis est valable 30 jours, jusqu'au <strong>{{ $validite }}</strong>. Prix susceptibles de varier après cette date.
</div>

{{-- FOOTER --}}
<div class="footer">
    <span>AutoMoto — La plateforme automobile N°1 — contact@automoto.fr</span>
    <span>Devis N° {{ $numero }} — généré le {{ $date }}</span>
</div>

</body>
</html>
