$(function(){
    init();
});

function init(){
    createHtmlListDep();
    createHtmlListUser();
    initAddDep();
    initUserList();
    initAddTrip();
    initEditDep();
    initDepSort();
    initTriggers();
}

function diplayCompte(str){
    str = str.slice(0, -2);
    Ply.dialog("alert", str);
    setTimeout(function(){
        //heurk ^^
        $('.ply-inside').css('width', '277px');
    },0);
}

function initAddTrip(){
    document.getElementById('addTrip').onclick = function () {
		Ply.dialog('prompt', {
			title: 'Ajouter un voyage',
			form: { name: 'nom' }
		}).done(function (ui) {
			var el = document.createElement('li');
			el.innerHTML = ui.data.name;
            document.getElementById('trip').appendChild(el);
		});
	};
}
var str;
function initTriggers(){
    $('#checkDep').on('click', function(){
        var list = localStorage.getItem('depList');
        var total = 0;
        var listDepenses = JSON.parse(list);
        var byPers = 0;
        var remboursement = '';
        str = "";
        $.each(listDepenses, function(index, value){
            //set total of depenses
            total += parseInt(value.montant);
        });
        //set depenses by person
        byPers = total / listDepenses.length;
        byPers = parseFloat(byPers.toFixed(2));

        $.each(listDepenses, function(index, value){
            //how many debt
            value.delta = byPers - value.montant;
            value.delta = parseFloat(value.delta.toFixed(2));

        });
        computeRefunds(listDepenses);
    });
}
function computeRefunds(list){
    $.each(list, function(rindex, receiver){
        //il doit recevoir
        if(receiver.delta < 0){
            $.each(list, function(gindex, giver){
                //on ne se rembourse pas sois meme et si = a la moyenne et pas deux qui doivent recevoir
                if(rindex == gindex || giver.delta == 0 || receiver.delta == 0 || (receiver.delta < 0 && giver.delta <0)) return;

                //donne plus au receiver que ce qu'il devrait recevoir
                if(receiver.delta < giver.delta){
                    //il donne tout ce qu'il doit et fini !

                    receiver.delta += Math.abs(giver.delta);
                    str += giver.nom+' doit donner '+giver.delta+'€ à '+receiver.nom+', ';
                    giver.delta = 0;

                }else{
                    if(Math.abs(receiver.delta) == Math.abs(giver.delta)){
                        //le giver doit autant que ce que le receiver a besoin
                        str += giver.nom+' doit donner '+giver.delta+'€ à '+receiver.nom+', ';
                        receiver.delta = 0;
                        giver.delta = 0;
                        //giver a donné delta a receiver;
                    }else{
                        //doit recevoir plus que ce que peux donner le giver
                        str += giver.nom+' doit donner '+giver.delta+'€ à '+receiver.nom+', ';
                        receiver.delta += giver.delta;
                        console.log(receiver.delta);
                        giver.delta = 0;

                    }
                }
            })
        }
    })

    var recall = false;
    $.each(list, function(i, v){
        //not completed, recall
        if(v.delta != 0){
            //si reste
            if(Math.abs(v.delta) < 1){
                v.delta = 0;
            }
            recall = true;
        }
    });
    if(recall){
        computeRefunds(list);
    }else{
        //finish
        diplayCompte(str);
    }
}

function getListDepHtml(index, data){
    return '<li data-index="'+parseInt(index)+'">'
                +'<span class="task">'+data.task+'</span>'
                +'<span class="name">'+data.nom +'</span>'
                +'<span class="sharedWith">'+data.sharedWith+'</span>'
                +'<span class="montant"><span class="value">'+ data.montant +'</span>€</span>'
                +'<i class="js-remove">✖</i>'
                +'<i class="js-edit"></i>'
            +'</li>';
}

function getListUserHtml(index, data){
    return '<li>'+data.nom+''
                +'<i class="js-remove">✖</i>'
            +'</li>';
}


function createHtmlListDep(){
    var list = localStorage.getItem('depList')
    var html = '';
    $.each(JSON.parse(list), function(index, value){
        html += getListDepHtml(index, value);
    });
    $('#editable').html(html);
}
function createHtmlListUser(){
    var list = localStorage.getItem('userList')
    var html = '';
    $.each(JSON.parse(list), function(index, value){
        html += getListUserHtml(index, value);
    });
    $('#users').html(html);
}

function initEditDep(){
    Ply.factory('editDepense', function (options, data, resolve) {
        options.flags = {
            closeBtn: true,
            closeByEsc: true,
            closeByOverlay: true,
            visibleOverlayInStack: true
        };
        options.onaction = function (ui) {
            var data = ui.data;

            /*check montant*/
            if(!data.montant || !$.isNumeric(data.montant)){
                $('input[name="montant"]').addClass('ply-invalid');
                return !ui.state;
            }

            //check nom
            if(!data.nom){
                $('input[name="nom"]').addClass('ply-invalid');
                return !ui.state;
            }

            //check nomuser
            if(!data.nomuser){
                $('input[name="nomuser"]').addClass('ply-invalid');
                return !ui.state;
            }else{
                var name = $.trim(data.nomuser);
                //Is user exist ?
                var userList = localStorage.getItem('userList');
                if(userList.toLowerCase().indexOf(name.toLowerCase()) === -1){
                    $('input[name="nomuser"]').addClass('ply-invalid');
                    return !ui.state;
                }
            }

            //check shared
            if(!data.sharedWith){
                $('input[name="sharedWith"]').addClass('ply-invalid');
                return !ui.state;
            }else{
                var sharedWithList = data.sharedWith.split(',');

                var userList = localStorage.getItem('userList');
                var error = false;
                if(!userList){
                    $('input[name="nomuser"]').addClass('ply-invalid');
                    $('input[name="sharedWith"]').addClass('ply-invalid');
                     return !ui.state;
                }
                $.each(sharedWithList, function(index, value){
                    var name = $.trim(value);
                    //Is user exist ?
                    if(userList.toLowerCase().indexOf(name.toLowerCase()) === -1){
                        $('input[name="sharedWith"]').addClass('ply-invalid');
                        error = true;
                        return false;
                    }
                })
                if(error) return !ui.state;

            }
        };
        options.onopen = function(options){
            $('.ply-inside input[name="nom"]').val(window.task);
            $('.ply-inside input[name="nomuser"]').val(window.nom);
            $('.ply-inside input[name="sharedWith"]').val(window.sharedWith);
            $('.ply-inside input[name="montant"]').val(window.montant);
        }
        // Use base factory
        Ply.factory.use('base', options, {
            title: 'Enregistrer une dépense',
            form: {
                nom: 'Nom de la dépense',
                nomuser: 'Nom du bénévole',
                sharedWith : 'Personnes concernées séparées par une virgule',
                montant: 'Montant en €',
            },
            ok: 'Enter',
            cancel: false
        }, resolve);
    });
}

function initAddDep(){
    document.getElementById('addDep').onclick = function () {
        Ply.dialog('addDepense').done(function (ui) {
            var el = document.createElement('li');
            var maxI = $('#editable li:last-child').data('index');
            if(typeof maxI == 'undefined'){
                maxI = -1;
            }

            el.dataset.index = maxI +1;
            el.innerHTML = '<span class="task">'+ui.data.nom+'</span><span class="name">'+ui.data.nomuser +'</span><span class="sharedWith">'+ui.data.sharedWith+'</span><span class="montant"><span class="value">'+ ui.data.montant +'</span>€</span> <i class="js-remove">✖</i><i class="js-edit"></i>';
            editableList.el.appendChild(el);
            editableList.destroy();
            //trickyyyyy
            setTimeout(function(){
                initDepSort()
            }, 0);
            saveDatasDep('#editable');
        });
    };
    Ply.factory('addDepense', function (options, data, resolve) {
        options.flags = {
            closeBtn: true,
            closeByEsc: true,
            closeByOverlay: true,
            visibleOverlayInStack: true
        };

        options.onaction = function (ui) {
            var data = ui.data;

            /*check montant*/
            if(!data.montant || !$.isNumeric(data.montant)){
                $('input[name="montant"]').addClass('ply-invalid');
                return !ui.state;
            }

            //check nom
            if(!data.nom){
                $('input[name="nom"]').addClass('ply-invalid');
                return !ui.state;
            }

            //check nomuser
            if(!data.nomuser){
                $('input[name="nomuser"]').addClass('ply-invalid');
                return !ui.state;
            }else{
                var name = $.trim(data.nomuser);
                //Is user exist ?
                var userList = localStorage.getItem('userList');
                if(userList.toLowerCase().indexOf(name.toLowerCase()) === -1){
                    $('input[name="nomuser"]').addClass('ply-invalid');
                    return !ui.state;
                }
            }

            //check shared
            if(!data.sharedWith){
                $('input[name="sharedWith"]').addClass('ply-invalid');
                return !ui.state;
            }else{
                var sharedWithList = data.sharedWith.split(',');

                var userList = localStorage.getItem('userList');
                var error = false;
                if(!userList){
                    $('input[name="nomuser"]').addClass('ply-invalid');
                    $('input[name="sharedWith"]').addClass('ply-invalid');
                     return !ui.state;
                }
                $.each(sharedWithList, function(index, value){
                    var name = $.trim(value);
                    //Is user exist ?
                    if(userList.toLowerCase().indexOf(name.toLowerCase()) === -1){
                        $('input[name="sharedWith"]').addClass('ply-invalid');
                        error = true;
                        return false;
                    }
                })
                if(error) return !ui.state;

            }

        };
        // Use base factory
        Ply.factory.use('base', options, {
            title: 'Enregistrer une dépense',
            form: {
                nom: 'Nom de la dépense',
                nomuser: 'Nom du bénévole',
                sharedWith : 'Personnes concernées séparées par une virgule ou "all" pour tous le monde',
                montant: 'Montant en €',
            },
            ok: 'Enter',
            cancel: false
        }, resolve);
    });
}

function initUserList(){

    var editableList = Sortable.create(users, {
        filter: '.js-remove',
        onFilter: function (evt) {
            var el = editableList.closest(evt.item); // get dragged item
            el && el.parentNode.removeChild(el);
            saveDatasUser('#users');
        }
    });
    document.getElementById('addUser').onclick = function () {
		Ply.dialog('prompt', {
			title: 'Ajouter un bénévole',
			form: { name: 'nom' }
		}).done(function (ui) {
			var el = document.createElement('li');
			el.innerHTML = ui.data.name + '<i class="js-remove">✖</i>';
			editableList.el.appendChild(el);
            saveDatasUser('#users');
		});
	};
}

var editableList = '';
function initDepSort(){
    var editable = document.getElementById("editable");
    editableList = Sortable.create(editable, {
      filter: 'i',
      animation : 150,


      onFilter: function (evt) {
          var item = evt.item,
              ctrl = evt.target;
          if (Sortable.utils.is(ctrl, ".js-remove")) {  // Click on remove button
              item.parentNode.removeChild(item); // remove sortable item
              saveDatasDep('#editable');
          }
          else if (Sortable.utils.is(ctrl, ".js-edit")) {  // Click on edit link
              //get clicked value
              window.itemIDX = item.dataset.index;
              //save values

              window.nom = $('#editable li[data-index='+window.itemIDX+']').find('.name').text();
              window.montant = $('#editable li[data-index='+window.itemIDX+']').find('.montant .value').text();
              window.task = $('#editable li[data-index='+window.itemIDX+']').find('.task').text();
              window.sharedWith = $('#editable li[data-index='+window.itemIDX+']').find('.sharedWith').text();

              //setvalues on done
              Ply.dialog('editDepense').done(function (ui) {
                  $('#editable li[data-index="'+window.itemIDX+'"] .task').html(ui.data.nom);
                  $('#editable li[data-index="'+window.itemIDX+'"] .name').html(ui.data.nomuser);
                  $('#editable li[data-index="'+window.itemIDX+'"] .sharedWith').html(ui.data.sharedWith);
                  $('#editable li[data-index="'+window.itemIDX+'"] .montant .value').html(ui.data.montant);

                  saveDatasDep('#editable');
              });
          }
      }
    });
}

function saveDatasDep(el){
    var depList = '';
    $.each($(el+' li'), function(index, value){
        var montant = $(this).find('.montant .value').text();
        var name = $(this).find('.name').text();
        var index = $(this).data('index');
        var sharedWith = $(this).find('.sharedWith').text();
        var task = $(this).find('.task').text();

        depList += '{"index": "' + index +'", "nom": "' + name + '", "montant": "' + montant + '", "sharedWith": "' + sharedWith + '", "task": "' + task + '"},';


    });
    depList = depList.slice(0, -1);

    localStorage.setItem('depList', "["+depList+"]");
}
function saveDatasUser(el){
    var userList = '';
    $.each($(el+' li'), function(index, value){
        var name = $(this).text();
        name = name.slice(0, -1);
        userList += '{"nom": "' + name + '"},';

    });
    userList = userList.slice(0, -1);

    localStorage.setItem('userList', "["+userList+"]");
}
