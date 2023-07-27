function vizualizarEmpresa(id_empresa){
    var bltEmpresa = document.getElementById(id_empresa)
    bltEmpresa.click()
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
function EditarUsuario(usuario){
    console.log(usuario.id_setor)
    var btn = document.getElementById('EditarUsuarioBtn')
    document.getElementById('id_user').value = usuario.id
    document.getElementById('nameEdit').value = usuario.name
    document.getElementById('emailEdit').value = usuario.email
    var SetorUsuario =document.getElementById('SetoreUsuario'+usuario.id_setor)
    SetorUsuario.setAttribute('selected', true)
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
