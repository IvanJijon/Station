var jsonListLeft = new Array();var jsonListRight = new Array();function prepareElem(){	$('.sortable-left li').each(function(){		jsonListLeft.push({'val':$(this).attr('data-val'),'id':$(this).attr('id'),'content':$(this).html()});	});	$('.sortable-right li').each(function(){		jsonListRight.push({'val':$(this).attr('data-val'),'id':$(this).attr('id'),'content':$(this).html()});	});}function refreshElemListe(){	$('.connectedSortable ul li').unbind('click');	$('.connectedSortable ul li').click(function(){		if($(this).hasClass('selected')){			$(this).removeClass('selected');		}else{			$(this).addClass('selected');		}	});}$(document).ready(function(){	prepareElem();		$( ".sortable-left, .sortable-right" ).sortable({	 connectWith: ".connectedSortable"	 });	refreshElemListe();		$('.go-to-right').click(function(){				// Pour chaque rubrique sur la colonne de GAUCHE qui est selectionnee :		$('.sortable-left li.selected').each(function(){						// On la rajoute à la colonne de droite sans verification
			jsonListRight.push({'val':$(this).attr('data-val'),'id':$(this).attr('id'),content:$(this).html()});			// On recupere la liste de GAUCHE dans dans tabLeft
			var tabLeft = jsonListLeft;			// Puis on la reinitialise
			jsonListLeft = new Array();			// On va balayer tabLeft...
			for(i=0;i<tabLeft.length;i++){				// ... pour verifier : si la rubrique en cours n'y est pas deja dans tabLeft
				if($(this).attr('id')!=tabLeft[i].id){					// alors on la rajoute dans jsonListLeft
					jsonListLeft.push({'val':tabLeft[i].val,'id':tabLeft[i].id,content:tabLeft[i].content});						}			}			// la rubrique ne doit plus être 'selected'			$(this).removeClass('selected');			// on la clone dans la colonne de DROITE			$(this).clone().appendTo('.sortable-right');						// on l'enleve du coup de la colonne de GAUCHE
			$(this).remove();			// finalement on raffraichi la rubrique en cours de traitement 
			refreshElemListe();		});		// ce return est necessaire pour ne pas valider le formulaire		return false;	});	$('.go-to-left').click(function(){		$('.sortable-right li.selected').each(function(){			jsonListLeft.push({'val':$(this).attr('data-val'),'id':$(this).attr('id'),'content':$(this).html()});			var tabRight= jsonListRight;			jsonListRight = new Array();			for(i=0;i<tabRight.length;i++){				if($(this).attr('id')!=tabRight[i].id){					jsonListRight.push({'val':tabRight[i].val,'id':tabRight[i].id,'content':tabRight[i].content});						}			}			$(this).removeClass('selected');			$(this).clone().appendTo('.sortable-left');			$(this).remove();			refreshElemListe();		});		return false;	});			//console.log(jsonElemList);	$('.filtre-left').keyup(function(){		var tab = new Array();		var recherche = $(this).val().toLowerCase(); //la chaîne de caractères tappés en recherche		var length = recherche.length; //length de la chaîne de caractères tappés en recherche		// on parcourre toute la liste de gauche et pour chaque valeur...		console.log(recherche);		for(i=0;i<jsonListLeft.length;i++){			var valTemp = jsonListLeft[i].content.toLowerCase();	//on récupère la valeur du texte affiché dans cet élément (cf conception de jsonListLeft)						if(valTemp.includes(recherche)){				//console.log(i);				tab.push(i);				console.log(valTemp + " includes " + recherche);			}		}		var dom ="";		for(i=0;i<tab.length;i++){			dom += '<li id="'+jsonListLeft[tab[i]].id+'" data-val="'+jsonListLeft[tab[i]].val+'">'+jsonListLeft[tab[i]].content+'</li>';		}		$('.sortable-left').html(dom); //on affiche les éléments de la liste de "li" construite dans "dom"		$('.sortable-left').scrollTop(0); //on remet le scroll au tout début		$('.sortable-left').sortable('destroy');		$('.sortable-left').unbind();		$('.sortable-right').sortable('destroy');		$('.sortable-right').unbind();		$(".sortable-left, .sortable-right" ).sortable({			 connectWith: ".connectedSortable"		});		refreshElemListe();	});		/* //console.log(jsonElemList);	$('.filtre-left').keyup(function(){		var tab = new Array();		var value = $(this).val().toLowerCase();		var length = value.length; //length de la chaîne de caractères tappés en recherche		// on parcourre toute la liste de gauche et pour chaque valeur...		for(i=0;i<jsonListLeft.length;i++){			var valTemp = jsonListLeft[i].val;	//on récupère la valeur de data-val (cf conception de jsonListLeft)			if(valTemp.substr(0,length) == value){				console.log(i);				tab.push(i);			}		}		var dom ="";		for(i=0;i<tab.length;i++){			dom += '<li id="'+jsonListLeft[tab[i]].id+'" data-val="'+jsonListLeft[tab[i]].val+'">'+jsonListLeft[tab[i]].content+'</li>';		}		$('.sortable-left').html(dom);		$('.sortable-left').scrollTop(0);		$('.sortable-left').sortable('destroy');		$('.sortable-left').unbind();		$('.sortable-right').sortable('destroy');		$('.sortable-right').unbind();		$(".sortable-left, .sortable-right" ).sortable({			 connectWith: ".connectedSortable"		});		refreshElemListe();	}); */		$('.filtre-right').keyup(function(){		var tab = new Array();		var recherche = $(this).val().toLowerCase(); ;		var length = recherche.length;		for(i=0;i<jsonListRight.length;i++){			var valTemp = jsonListRight[i].content.toLowerCase();			if(valTemp.includes(recherche)){				//console.log(i);				tab.push(i);			}		}		var dom ="";		for(i=0;i<tab.length;i++){			dom += '<li id="'+jsonListRight[tab[i]].id+'" data-val="'+jsonListRight[tab[i]].val+'">'+jsonListRight[tab[i]].content+'</li>';		}		$('.sortable-right').html(dom);		$('.sortable-right').scrollTop(0);		$('.sortable-left').sortable('destroy');		$('.sortable-left').unbind();		$('.sortable-right').sortable('destroy');		$('.sortable-right').unbind();		$(".sortable-left, .sortable-right" ).sortable({			 connectWith: ".connectedSortable"		});		refreshElemListe();	});		$('.submit-form').click(function(){		var elem = "";		for(i=0;i<jsonListRight.length;i++){			if(elem!=""){				elem+=";";			}			elem += jsonListRight[i].id;		}		$('#input-liste').val(elem);		$('#form-select').submit();	});});