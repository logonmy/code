var GridView={
	GridViewId:'',
	Maxrow:10,
	CellItem:[],
	Init:function(){
		var _self = this;
		for(var i=0 ;i<_self.Maxrow;i++)
		{
			_self.Addrow();
		}
		_self.Nexttabindex();
		_self.calculate();
		_self.autocompleteuser();
		_self.autocompetetype();
		_self.automarket();
	},
	Addrow:function(){
		var _self = this;
		var tr ="<tr>"+
					 "<td><input type='text' cellindex='1' class='cellitem txtbox market'  /></td>" +
					 "<td><input type='text' cellindex='1' class='cellitem txtbox userauto'  /></td>" +
					 "<td><input type='text' cellindex='1' class='cellitem txtbox typeauto'  /></td>" +
					 "<td><input type='text' cellindex='2' class='cellitem txtbox calculate'  /></td>" +
					 "<td><input type='text' cellindex='3' class='cellitem txtbox calculate'  /></td>" +
					 "<td><input type='text' cellindex='3' class='cellitem txtbox real'  /></td>" +
					 "<td><input type='text' cellindex='4' class='cellitem txtbox calculate' value='0' /></td>" +
					 "<td><input type='text' cellindex='5' class='cellitem txtbox result'  /></td>" +
				"</tr>";
		$("#" + _self.GridViewId).append(tr);
	},
	Delete:function()
	{
		
	},
	Nexttabindex:function()
	{
		var _self = this;
		$(".txtbox").keydown(function(e){
			var keyCode =  e.which;
			
			if(13 == keyCode)
			{ 
				e.preventDefault();
				var rowtdlen=$(this).parent().parent().find("td").length;
				var trcount=$(this).parent().parent().parent().find("tr").length;
				var currindex= $(this).parent()[0].cellIndex;
				var currowindex=$(this).parent().parent()[0].rowIndex;
				if(currindex== rowtdlen-1)
				{
					//换行
					if(currowindex==trcount-1)
					{
						_self.Addrow();
						_self.Nexttabindex();
						_self.calculate();
						_self.autocompleteuser();
						_self.autocompetetype();
						_self.automarket();
					}
					var thistd= $(this).parent().parent().parent().find("tr:eq("+ (parseInt(currowindex) +1) +") td:eq(0)");
					 $control =$(thistd.find("input"));
					 $control.each(function(i){
						$(this).focus();
					 });
					
				}else
				{
					//换列
					 var nextindex = parseInt(currindex) +1;
					 var thistd= $(this).parent().parent().find("td:eq("+ nextindex +")");
					 $control =$(thistd.find("input"));
					 $control.each(function(i){
						$(this).focus();
					 });
					 
				}
			}
		});
	},
	calculate:function()
	{
		$(".calculate").blur(function(){
			var	currtr= $(this).parent().parent();
			var Items= currtr.find(".calculate");
			var result = currtr.find(".result");
			var real= currtr.find(".real");
			Item1=Items[0].value;
			Item2=Items[1].value;
			Item3=Items[2].value;
			var totle=Item1 * Item2 - Item3;
			result[0].value=totle.toFixed(0);
			real[0].value=(Item1 * Item2).toFixed(0);
		});	
	},
	autocompleteuser:function(){
		var _self = this;
		var stockInfoJson = [
			{ name: "张三", code: "1",spell:"zs" },
			{ name: "李四", code: "2",spell:"ls"},
			{ name: "王五", code: "3",spell:"ww" }
		];
		_self.autocomplete(stockInfoJson,'.userauto');
	
	},
	autocompetetype:function(){
		var _self = this;
		var stockInfoJson = [
			{ name: "品种1", code: "1",spell:"pz1" },
			{ name: "品种2", code: "2",spell:"pz2"},
			{ name: "良种", code: "3",spell:"lz" }
		];
		_self.autocomplete(stockInfoJson,'.typeauto');
	},
	automarket:function(){
		var _self = this;
		var stockInfoJson = [
			{ name: "西丽", code: "1",spell:"xl" },
			{ name: "布吉", code: "2",spell:"bj"},
			{ name: "木头龙", code: "3",spell:"mtl" }
		];
		_self.autocomplete(stockInfoJson,'.market');
	},
	autocomplete:function(source,selector)
	{
		
		$(selector).autocomplete(source, {
		minChars: 1,
		matchCase:false,//不区分大小写
		autoFill: false,
		max: 10,
		formatItem: function(row, i, max,term) {
			var v = $(selector).val();		
			return  row.name + " (" + row.code + ")";
			if(row.code.indexOf(v) == 0 || row.spell.indexOf(v)==0)
			{
				return  row.name + " (" + row.code + ")";
			}
			else
				return false;
		},
		formatMatch: function(row, i, max) {
			return row.name + " (" + row.code+")";
		},
		formatResult: function(row) {
			return row.name;
		},
		reasultSearch:function(row,v)//本场数据自定义查询语法 注意这是我自己新加的事件
		{
			//自定义在code或spell中匹配
			if(row.data.code.indexOf(v) == 0 || row.data.spell.indexOf(v) == 0)
			{
				return row;
			}
			else
				return false;			
		}
		});
		 
		
	}
	
	

}