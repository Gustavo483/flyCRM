<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Accordion Bootstrap</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <style>
        .colorgray{
            color: gray;
            font-size: 20px;
        }
        .NameLead{
            color:#3a41e0;
        }
        .divTemperatura{
            margin-bottom: 10px;
            width: 110px;
            height: 10px;
            border-radius: 10px;
            background: rgb(222,201,255);
            background: linear-gradient(90deg, rgba(222,201,255,1) 0%, rgba(163,130,255,1) 31%, rgba(255,147,121,1) 38%, rgba(255,190,187,1) 64%, rgba(255,158,21,1) 100%);
        }
        .flexName{
            display: flex;
            align-items: end;
        }
        .divService{
            padding: 2px;
            border-radius: 10px;
            background: #5bfda6;
            color: green;
        }
        .linksLeads{
            width: 220px;
            background: white;
            padding: 10px;
            border-radius: 10px;
            border: 1px solid blue;
            text-align: center;
            text-decoration: none;
        }
        .DivOportunidade{
            border: 1px solid blue;
            color: blue;
            border-radius: 10px;
            padding: 10px;
        }
        .linksLeads:hover{
            box-shadow: 0px 10px 15px -3px rgba(71, 102, 255, 0.33);
            border: none;
        }

        .ccddc{
            background: #f4f4f4;
        }
        .DivPrincipal{
            width: 70%;
            border-radius: 10px;
            background: white;
        }
        .DivInfo{
            width: 28%;
            border: 1px solid red;
        }


    </style>
</head>
<body class="container ccddc">
<div class=" colorgray pt-5">
    Leads > detalhamento lead
</div>
<div class="flexName">
    <h1 class="mt-5 NameLead p-0 me-2">Gustavo Spindola</h1>
    <div class="divTemperatura"></div>
</div>
<div class="mt-2">
    <span class="divService px-2">Curso tecnico em logistica</span>
</div>

<div class="d-flex mt-5">
    <a class="linksLeads me-3">Adicionar observação</a>
    <a class="linksLeads me-3">Adicionar Oportunidade </a>
    <a class="linksLeads me-3">Converter em cliente</a>
</div>

<div class="d-flex justify-content-between mt-5">
    <div class="DivPrincipal p-3">
        <div>
            <div class="DivOportunidade">10/07/2023 ás 16:32 - Andre Vendedos adicinou uma oportunidade para 18/07/2023</div>

        </div>
    </div>
    <div class="DivInfo ">sdfsdf</div>
</div>


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
</body>
</html>
