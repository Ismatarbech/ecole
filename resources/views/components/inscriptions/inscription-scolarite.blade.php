<style>
    body {
        font-family: Arial, sans-serif;
        color: #000;
        background: #f6f9ff;
    }

    .fiche-containeri {
        background: #fff;
        padding: 30px;
        margin: 30px auto;
        max-width: 1100px;
        box-shadow: 0 0 10px rgba(0,0,0,.08);
    }

    .fiche-headeri {
        text-align: center;
        border-bottom: 2px solid #000;
        padding-bottom: 15px;
    }

    .fiche-headeri h4,
    .fiche-headeri p {
        margin: 5px;
    }

    .school-namei {
        font-size: 18px;
        font-weight: bold;
    }

    .section-titlei {
        margin-top: 25px;
        margin-bottom: 10px;
        padding: 8px;
        background: #ddd;
        border: 1px solid #000;
        font-weight: bold;
    }

    .info-gridi {
        display: grid;
        grid-template-columns: 1fr 1fr;
        border: 1px solid #000;
    }

    .info-itemi {
        padding: 10px;
        border-bottom: 1px solid #000;
    }

    .info-item:nth-child(odd) {
        border-right: 1px solid #000;
    }

    .photoi {
        width: 120px;
        height: 140px;
        border: 1px solid #000;
        object-fit: cover;
    }

    .photo-containeri {
        text-align: center;
        margin-bottom: 15px;
    }

    .paiement-tablei {
        width: 100%;
        border-collapse: collapse;
    }

    .paiement-tablei th,
    .paiement-tablei td {
        border: 1px solid #000;
        padding: 9px;
        text-align: center;
    }

    .paiement-tablei th {
        background: #ddd;
    }

    .declarationi {
        border: 1px solid #000;
        padding: 15px;
        margin-top: 20px;
        min-height: 80px;
    }

    .signaturesi {
        display: flex;
        justify-content: space-between;
        margin-top: 70px;
        text-align: center;
    }

    .signatures divi {
        width: 30%;
    }

    .actionsi {
        max-width: 1100px;
        margin: 20px auto;
        text-align: right;
    }

    @media print {
        body {
            background: #fff;
        }

        .fiche-container {
            margin: 0;
            padding: 10px;
            box-shadow: none;
            max-width: 100%;
        }

        .actions {
            display: none !important;
        }
    }
</style>


