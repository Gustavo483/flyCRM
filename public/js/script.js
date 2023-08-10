function vizualizarEmpresa(id_empresa){
    var btnEmpresa = document.getElementById(id_empresa)
    btnEmpresa.click()
}

function vizualizarLead(id_ledas){
    console.log(id_ledas)
    var btnEmpresa = document.getElementById('Leads'+id_ledas)
    console.log(btnEmpresa)
    btnEmpresa.click()
}
function vizualizarLeadKanban(id_ledas){
    var btnEmpresa = document.getElementById('LeadsKanban'+id_ledas)
    btnEmpresa.click()
}

function abrirLead(id_lead){
    document.getElementById('Lead'+id_lead).click()
}

function abrirDiv(id_elemento, cabecalho){
    var div = document.getElementById(id_elemento)
    var divCabecalho = document.getElementById(cabecalho)
    console.log(divCabecalho)
    var btn = document.getElementById(cabecalho+'Desenho')
    btn.classList.toggle('backgroud233')
    div.classList.toggle('none')
    divCabecalho.classList.toggle('divCabecalho')
    divCabecalho.classList.toggle('divCabecalho2')
}

function testeFuncao() {
    var periodicidade = document.getElementById('periodicidade').value
    var divPeriodicidade = document.getElementById('divPeriodicidade')
    var divPeriodicidadeDia = document.getElementById('divPeriodicidadeDia')
    if (periodicidade) {
        divPeriodicidade.classList.toggle('none')
        divPeriodicidadeDia.classList.toggle('none')
    } else {
        divPeriodicidade.classList.toggle('none')
        divPeriodicidadeDia.classList.toggle('none')
    }

    console.log(divPeriodicidade, divPeriodicidadeDia)
}

function vizualizarTarefa(dados){
    console.log('entrei aqui')
    document.getElementById('inputId'). value = dados.id_toDoKhanban
    document.getElementById('inputIdDelete'). value = dados.id_toDoKhanban
    document.getElementById('st_descricaoEditKanban'). value = dados.st_descricao
    console.log('entrei aqui e esta tudo certo',dados)
    document.getElementById('EditarTarefa').click()
}
function EditarUsuario(usuario){
    console.log(usuario.id_setor)
    var btn = document.getElementById('EditarUsuarioBtn')
    document.getElementById('id_user').value = usuario.id
    document.getElementById('nameEdit').value = usuario.name
    document.getElementById('emailEdit').value = usuario.email
    var SetorUsuario =document.getElementById('SetoreUsuario'+usuario.id_setor)
    if (SetorUsuario){
        SetorUsuario.setAttribute('selected', true)
    }
    btn.click()
}
function DeleteUsuario(usuario){
    var btn = document.getElementById('DeletarUsuarioBtn')
    document.getElementById('id_userDelete').value = usuario.id
    document.getElementById('nameUsario').innerText = usuario.name
    btn.click()
}

function DeleteStatus(status){
    var btn = document.getElementById('DeletarStatusBtn')
    document.getElementById('id_statusDelete').value = status.id_columnsKhanban
    document.getElementById('StTituloDelete').innerText = status.st_titulo
    btn.click()
}
function EditarStatus(status){
    var btn = document.getElementById('EditarStatusBtn')
    console.log(btn)
    document.getElementById('id_statusEdit').value = status.id_columnsKhanban
    document.getElementById('int_posicaoStatusEdit').value = status.int_posicao
    document.getElementById('st_nomeStatusEdit').value = status.st_titulo
    document.getElementById('st_colorStatusEdit').value = status.st_color
    btn.click()
}

function EditarMidias(midia){
    var btn = document.getElementById('EditarMidiaBtn')
    console.log(btn)
    document.getElementById('id_midiaEdit').value = midia.id_midia
    document.getElementById('st_nomeMidiaEdit').value = midia.st_nomeMidia
    btn.click()
}
function DeleteMidia(midia){
    var btn = document.getElementById('DeletarMidiaBtn')
    document.getElementById('id_midiaDelete').value = midia.id_midia
    document.getElementById('st_nomeMidiaDelete').innerText = midia.st_nomeMidia
    btn.click()
}

function EditarGrupo(grupo){
    var btn = document.getElementById('EditarGrupoBtn')
    console.log(btn)
    document.getElementById('id_GrupoEdit').value = grupo.id_grupo
    document.getElementById('st_nomeGrupoEdit').value = grupo.st_nomeGrupo
    btn.click()
}
function DeleteGrupo(grupo){
    var btn = document.getElementById('DeletarGrupoBtn')
    document.getElementById('id_GrupoDelete').value = grupo.id_grupo
    document.getElementById('st_nomeGrupoDelete').innerText = grupo.st_nomeGrupo
    btn.click()
}

function EditarFase(fase){
    var btn = document.getElementById('EditarFaseBtn')
    document.getElementById('id_faseEdit').value = fase.id_fase
    document.getElementById('st_nomeFaseEdit').value = fase.st_nomeFase
    btn.click()
}
function DeleteFase(fase){
    var btn = document.getElementById('DeletarFaseBtn')
    document.getElementById('id_faseDelete').value = fase.id_fase
    document.getElementById('st_nomeFaseDelete').innerText = fase.st_nomeFase
    btn.click()
}

function EditarOrigem(origem){
    var btn = document.getElementById('EditarOrigemBtn')
    document.getElementById('id_origemEdit').value = origem.id_origem
    document.getElementById('st_nomeOrigemEdit').value = origem.st_nomeOrigem
    btn.click()
}
function DeleteOrigem(origem){
    var btn = document.getElementById('DeletarOrigemBtn')
    document.getElementById('id_origemDelete').value = origem.id_origem
    document.getElementById('st_nomeOrigemDelete').innerText = origem.st_nomeOrigem
    btn.click()
}

function EditarCampanha(campanha){
    var btn = document.getElementById('EditarCampanhaBtn')
    document.getElementById('id_campanhaEdit').value = campanha.id_campanha
    document.getElementById('st_nomeCampanhaEdit').value = campanha.st_nomeCampanha
    btn.click()
}
function DeleteCampanha(campanha){
    var btn = document.getElementById('DeletarCampanhaBtn')
    document.getElementById('id_campanhaDelete').value = campanha.id_campanha
    document.getElementById('st_nomeCampanhaDelete').innerText = campanha.st_nomeCampanha
    btn.click()
}
function EditarSetor(setor){
    var btn = document.getElementById('EditarSetorBtn')
    document.getElementById('id_setorEdit').value = setor.id_setor
    document.getElementById('st_nomeSetorEdit').value = setor.st_nomeSetor
    btn.click()
}
function DeleteSetor(setor){
    var btn = document.getElementById('DeletarSetorBtn')
    document.getElementById('id_setorDelete').value = setor.id_setor
    document.getElementById('st_nomeSetorDelete').innerText = setor.st_nomeSetor
    btn.click()
}
function DeleteProduto(produto){
    var btn = document.getElementById('DeletarProdutoBtn')
    document.getElementById('id_produtoServicoDelete').value = produto.id_produtoServico
    document.getElementById('st_nomeProdutoServicoDelete').innerText = produto.st_nomeProdutoServico
    btn.click()
}
function EditarProduto(produto){
    var btn = document.getElementById('EditarProdutoBtn')
    console.log(btn)
    document.getElementById('id_ProdutoServicoEdit').value = produto.id_produtoServico
    document.getElementById('st_nomeProdutoServicoEdit').value = produto.st_nomeProdutoServico
    document.getElementById('st_descricaoEdit').value = produto.st_descricao
    document.getElementById('st_colorProdutoServicoEdit').value = produto.st_color
    btn.click()
}
