var jsonListLeft = new Array();
			jsonListRight.push({'val':$(this).attr('data-val'),'id':$(this).attr('id'),content:$(this).html()});
			var tabLeft = jsonListLeft;
			jsonListLeft = new Array();
			for(i=0;i<tabLeft.length;i++){
				if($(this).attr('id')!=tabLeft[i].id){
					jsonListLeft.push({'val':tabLeft[i].val,'id':tabLeft[i].id,content:tabLeft[i].content});		
			$(this).remove();
			refreshElemListe();