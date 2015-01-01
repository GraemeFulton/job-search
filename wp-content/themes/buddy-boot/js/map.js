var div = document.getElementById("map");      
var width=div.offsetWidth;
original_width=400;
original_height=400;
scale_factor=width/original_width;
var height=original_height*scale_factor;                    
var transformation='S'+scale_factor+','+scale_factor+',0,0'; 

      var rsr = new ScaleRaphael("map",400,400);
      
      function resizePaper(){
        var win = $(this);
        rsr.changeSize(win.width()-100, win.height()-100, true, true);
      }
      resizePaper();
      $(window).resize(resizePaper); 



var Isle_of_Man_1_ = rsr.set();
var Isle_of_Man = rsr.path("M199.6,203.9h-7.9c-1.1,0-2-0.9-2-2v-9.1c0-1.1,0.9-2,2-2h7.9c1.1,0,2,0.9,2,2v9.1   C201.6,203,200.7,203.9,199.6,203.9z").attr({id: 'Isle_of_Man',fill: '#59BCAC',parent: 'Isle_of_Man_1_','stroke-width': '0','stroke-opacity': '1'}).data('id', 'Isle_of_Man');
Isle_of_Man_1_.attr({'id': 'Isle_of_Man_1_','name': 'Isle_of_Man_1_'});
var North_West = rsr.set();
var path_a = rsr.path("M254.5,176.1h-24c-1.1,0-2-0.9-2-2v-25.5c0-1.1,0.9-2,2-2h24c1.1,0,2,0.9,2,2v25.5   C256.5,175.2,255.6,176.1,254.5,176.1z").attr({fill: '#008C72',parent: 'North_West','stroke-width': '0','stroke-opacity': '1'}).data('id', 'path_a');
var path_b = rsr.path("M254.5,231.8h-7.2c-1.1,0-2-0.9-2-2v-22.3c0-1.1,0.9-2,2-2h7.2c1.1,0,2,0.9,2,2v22.3   C256.5,230.9,255.6,231.8,254.5,231.8z").attr({fill: '#008C72',parent: 'North_West','stroke-width': '0','stroke-opacity': '1'}).data('id', 'path_b');
var path_c = rsr.path("M254.5,203.9h-18.4c-1.1,0-2-0.9-2-2v-22.3c0-1.1,0.9-2,2-2h18.4c1.1,0,2,0.9,2,2v22.3   C256.5,203,255.6,203.9,254.5,203.9z").attr({fill: '#008C72',parent: 'North_West','stroke-width': '0','stroke-opacity': '1'}).data('id', 'path_c');
North_West.attr({'id': 'North_West','name': 'North_West'});
var Midlands = rsr.set();
var path_d = rsr.path("M254.5,259.2h-7.2c-1.1,0-2-0.9-2-2v-21.4c0-1.1,0.9-2,2-2h7.2c1.1,0,2,0.9,2,2v21.4   C256.5,258.3,255.6,259.2,254.5,259.2z").attr({fill: '#6EC0A6',parent: 'Midlands','stroke-width': '0','stroke-opacity': '1'}).data('id', 'path_d');
var path_e = rsr.path("M308.6,259.2h-21.7c-1.1,0-2-0.9-2-2v-21.4c0-1.1,0.9-2,2-2h21.7c1.1,0,2,0.9,2,2v21.4   C310.6,258.3,309.7,259.2,308.6,259.2z").attr({fill: '#6EC0A6',parent: 'Midlands','stroke-width': '0','stroke-opacity': '1'}).data('id', 'path_e');
var path_f = rsr.path("M281.6,259.2h-21.3c-1.1,0-2-0.9-2-2v-21.4c0-1.1,0.9-2,2-2h21.3c1.1,0,2,0.9,2,2v21.4   C283.6,258.3,282.7,259.2,281.6,259.2z").attr({fill: '#6EC0A6',parent: 'Midlands','stroke-width': '0','stroke-opacity': '1'}).data('id', 'path_f');
var path_g = rsr.path("M326.1,259.2h-11.7c-1.1,0-2-0.9-2-2v-21c0-1.1,0.9-2,2-2h11.7c1.1,0,2,0.9,2,2v21   C328.1,258.3,327.2,259.2,326.1,259.2z").attr({fill: '#6EC0A6',parent: 'Midlands','stroke-width': '0','stroke-opacity': '1'}).data('id', 'path_g');
var path_h = rsr.path("M254.5,287.5h-7.2c-1.1,0-2-0.9-2-2v-22.1c0-1.1,0.9-2,2-2h7.2c1.1,0,2,0.9,2,2v22.1   C256.5,286.6,255.6,287.5,254.5,287.5z").attr({fill: '#6EC0A6',parent: 'Midlands','stroke-width': '0','stroke-opacity': '1'}).data('id', 'path_h');
var path_i = rsr.path("M308.7,287.5h-21.8c-1.1,0-2-0.9-2-2v-22.1c0-1.1,0.9-2,2-2h21.8c1.1,0,2,0.9,2,2v22.1   C310.7,286.6,309.8,287.5,308.7,287.5z").attr({fill: '#6EC0A6',parent: 'Midlands','stroke-width': '0','stroke-opacity': '1'}).data('id', 'path_i');
var path_j = rsr.path("M281.4,287.5h-21.1c-1.1,0-2-0.9-2-2v-22.1c0-1.1,0.9-2,2-2h21.1c1.1,0,2,0.9,2,2v22.1   C283.4,286.6,282.5,287.5,281.4,287.5z").attr({fill: '#6EC0A6',parent: 'Midlands','stroke-width': '0','stroke-opacity': '1'}).data('id', 'path_j');
Midlands.attr({'id': 'Midlands','name': 'Midlands'});
var Northern_Ireland = rsr.set();
var path_k = rsr.path("M121.6,171.9h-25c-1.1,0-2-0.9-2-2v-18.7c0-1.1,0.9-2,2-2h25c1.1,0,2,0.9,2,2v18.7   C123.6,171,122.7,171.9,121.6,171.9z").attr({fill: '#59BCAC',parent: 'Northern_Ireland','stroke-width': '0','stroke-opacity': '1'}).data('id', 'path_k');
var path_l = rsr.path("M147.7,206h-20.6c-1.1,0-2-0.9-2-2v-27.8c0-1.1,0.9-2,2-2h20.6c1.1,0,2,0.9,2,2V204   C149.7,205.1,148.8,206,147.7,206z").attr({fill: '#59BCAC',parent: 'Northern_Ireland','stroke-width': '0','stroke-opacity': '1'}).data('id', 'path_l');
var path_m = rsr.path("M121.6,206.1h-25c-1.1,0-2-0.9-2-2v-28c0-1.1,0.9-2,2-2h25c1.1,0,2,0.9,2,2v28   C123.6,205.2,122.7,206.1,121.6,206.1z").attr({fill: '#59BCAC',parent: 'Northern_Ireland','stroke-width': '0','stroke-opacity': '1'}).data('id', 'path_m');
var path_n = rsr.path("M141.8,171.9h-14.7c-1.1,0-2-0.9-2-2v-8.5c0-1.1,0.9-2,2-2h14.7c1.1,0,2,0.9,2,2v8.5   C143.8,171,142.9,171.9,141.8,171.9z").attr({fill: '#59BCAC',parent: 'Northern_Ireland','stroke-width': '0','stroke-opacity': '1'}).data('id', 'path_n');
var path_o = rsr.path("M90.7,205.4H67.8c-1.1,0-2-0.9-2-2v-27.2c0-1.1,0.9-2,2-2h22.9c1.1,0,2,0.9,2,2v27.2   C92.7,204.5,91.8,205.4,90.7,205.4z").attr({fill: '#59BBAC',parent: 'Northern_Ireland','stroke-width': '0','stroke-opacity': '1'}).data('id', 'path_o');
var path_p = rsr.path("M90.7,171.9H67.5c-1.1,0-2-0.9-2-2v-18.7c0-1.1,0.9-2,2-2h23.2c1.1,0,2,0.9,2,2v18.7   C92.7,171,91.8,171.9,90.7,171.9z").attr({fill: '#59BBAC',parent: 'Northern_Ireland','stroke-width': '0','stroke-opacity': '1'}).data('id', 'path_p');
Northern_Ireland.attr({'id': 'Northern_Ireland','name': 'Northern_Ireland'});
var Ireland = rsr.set();
var path_q = rsr.path("M140.6,237.7h-13.5c-1.1,0-2-0.9-2-2v-26.8c0-1.1,0.9-2,2-2h13.5c1.1,0,2,0.9,2,2v26.8   C142.6,236.8,141.7,237.7,140.6,237.7z").attr({fill: '#ABD6CC',parent: 'Ireland','stroke-width': '0','stroke-opacity': '1'}).data('id', 'path_q');
var path_r = rsr.path("M121.6,237.4h-25c-1.1,0-2-0.9-2-2v-26.5c0-1.1,0.9-2,2-2h25c1.1,0,2,0.9,2,2v26.5   C123.6,236.5,122.7,237.4,121.6,237.4z").attr({fill: '#ACD7CD',parent: 'Ireland','stroke-width': '0','stroke-opacity': '1'}).data('id', 'path_r');
var path_s = rsr.path("M121.6,269.5h-25c-1.1,0-2-0.9-2-2V241c0-1.1,0.9-2,2-2h25c1.1,0,2,0.9,2,2v26.5   C123.6,268.6,122.7,269.5,121.6,269.5z").attr({fill: '#ACD7CD',parent: 'Ireland','stroke-width': '0','stroke-opacity': '1'}).data('id', 'path_s');
var path_t = rsr.path("M90.7,270.4H69c-1.1,0-2-0.9-2-2v-26.5c0-1.1,0.9-2,2-2h21.7c1.1,0,2,0.9,2,2v26.5   C92.7,269.5,91.8,270.4,90.7,270.4z").attr({fill: '#ACD7CD',parent: 'Ireland','stroke-width': '0','stroke-opacity': '1'}).data('id', 'path_t');
var path_u = rsr.path("M63.8,270.4H38.9c-1.1,0-2-0.9-2-2v-26.5c0-1.1,0.9-2,2-2h24.8c1.1,0,2,0.9,2,2v26.5   C65.8,269.5,64.9,270.4,63.8,270.4z").attr({fill: '#ACD7CD',parent: 'Ireland','stroke-width': '0','stroke-opacity': '1'}).data('id', 'path_u');
var path_v = rsr.path("M90.7,237.7H67.5c-1.1,0-2-0.9-2-2v-26.5c0-1.1,0.9-2,2-2h23.2c1.1,0,2,0.9,2,2v26.5   C92.7,236.8,91.8,237.7,90.7,237.7z").attr({fill: '#ACD7CD',parent: 'Ireland','stroke-width': '0','stroke-opacity': '1'}).data('id', 'path_v');
var path_w = rsr.path("M62.2,205.4H32.8c-1.1,0-2-0.9-2-2v-27.2c0-1.1,0.9-2,2-2h29.4c1.1,0,2,0.9,2,2v27.2   C64.2,204.5,63.3,205.4,62.2,205.4z").attr({fill: '#ACD7CD',parent: 'Ireland','stroke-width': '0','stroke-opacity': '1'}).data('id', 'path_w');
var path_x = rsr.path("M62.2,222.8H49.5c-1.1,0-2-0.9-2-2v-11.9c0-1.1,0.9-2,2-2h12.7c1.1,0,2,0.9,2,2v11.9   C64.2,221.9,63.3,222.8,62.2,222.8z").attr({fill: '#ACD7CD',parent: 'Ireland','stroke-width': '0','stroke-opacity': '1'}).data('id', 'path_x');
var path_y = rsr.path("M63.5,289.8H32.8c-1.1,0-2-0.9-2-2v-14c0-1.1,0.9-2,2-2h30.7c1.1,0,2,0.9,2,2v14   C65.5,288.9,64.6,289.8,63.5,289.8z").attr({fill: '#ACD7CD',parent: 'Ireland','stroke-width': '0','stroke-opacity': '1'}).data('id', 'path_y');
var path_z = rsr.path("M90.7,289.8H69c-1.1,0-2-0.9-2-2v-14.2c0-1.1,0.9-2,2-2h21.7c1.1,0,2,0.9,2,2v14.2   C92.7,288.9,91.8,289.8,90.7,289.8z").attr({fill: '#ACD7CD',parent: 'Ireland','stroke-width': '0','stroke-opacity': '1'}).data('id', 'path_z');
var path_aa = rsr.path("M139.8,269.5h-12.7c-1.1,0-2-0.9-2-2V241c0-1.1,0.9-2,2-2h12.7c1.1,0,2,0.9,2,2v26.5   C141.8,268.6,140.9,269.5,139.8,269.5z").attr({fill: '#ACD7CD',parent: 'Ireland','stroke-width': '0','stroke-opacity': '1'}).data('id', 'path_aa');
var path_ab = rsr.path("M80.1,300.3H53c-1.1,0-2-0.9-2-2v-4.9c0-1.1,0.9-2,2-2h27.1c1.1,0,2,0.9,2,2v4.9   C82.1,299.4,81.2,300.3,80.1,300.3z").attr({fill: '#ACD7CD',parent: 'Ireland','stroke-width': '0','stroke-opacity': '1'}).data('id', 'path_ab');
var path_ac = rsr.path("M121.6,280.8h-25c-1.1,0-2-0.9-2-2v-6c0-1.1,0.9-2,2-2h25c1.1,0,2,0.9,2,2v6   C123.6,279.9,122.7,280.8,121.6,280.8z").attr({fill: '#ACD7CD',parent: 'Ireland','stroke-width': '0','stroke-opacity': '1'}).data('id', 'path_ac');
Ireland.attr({'id': 'Ireland','name': 'Ireland'});
var Scotland = rsr.set();
var path_ad = rsr.path("M225.3,37.1h-16.8c-1.1,0-2-0.9-2-2V11.7c0-1.1,0.9-2,2-2h16.8c1.1,0,2,0.9,2,2v23.4   C227.3,36.2,226.4,37.1,225.3,37.1z").attr({fill: '#42B4B9',parent: 'Scotland','stroke-width': '0','stroke-opacity': '1'}).data('id', 'path_ad');
var path_ae = rsr.path("M203.4,37.1H188c-1.1,0-2-0.9-2-2v-9.3c0-1.1,0.9-2,2-2h15.4c1.1,0,2,0.9,2,2v9.3   C205.4,36.2,204.5,37.1,203.4,37.1z").attr({fill: '#42B4B9',parent: 'Scotland','stroke-width': '0','stroke-opacity': '1'}).data('id', 'path_ae');
var path_af = rsr.path("M225.3,61.8h-16.8c-1.1,0-2-0.9-2-2V39.9c0-1.1,0.9-2,2-2h16.8c1.1,0,2,0.9,2,2v19.9   C227.3,60.9,226.4,61.8,225.3,61.8z").attr({fill: '#42B4B9',parent: 'Scotland','stroke-width': '0','stroke-opacity': '1'}).data('id', 'path_af');
var path_ag = rsr.path("M253.2,62.1h-22.8c-1.1,0-2-0.9-2-2V39.9c0-1.1,0.9-2,2-2h22.8c1.1,0,2,0.9,2,2v20.1   C255.2,61.2,254.3,62.1,253.2,62.1z").attr({fill: '#42B4B9',parent: 'Scotland','stroke-width': '0','stroke-opacity': '1'}).data('id', 'path_ag');
var path_ah = rsr.path("M203.4,62.1h-25.1c-1.1,0-2-0.9-2-2V39.9c0-1.1,0.9-2,2-2h25.1c1.1,0,2,0.9,2,2v20.1   C205.4,61.2,204.5,62.1,203.4,62.1z").attr({fill: '#42B4B9',parent: 'Scotland','stroke-width': '0','stroke-opacity': '1'}).data('id', 'path_ah');
var path_ai = rsr.path("M203.4,88.9h-25.1c-1.1,0-2-0.9-2-2V65.1c0-1.1,0.9-2,2-2h25.1c1.1,0,2,0.9,2,2v21.7   C205.4,88,204.5,88.9,203.4,88.9z").attr({fill: '#42B4B9',parent: 'Scotland','stroke-width': '0','stroke-opacity': '1'}).data('id', 'path_ai');
var path_aj = rsr.path("M203.4,117.7h-19.9c-1.1,0-2-0.9-2-2V91.9c0-1.1,0.9-2,2-2h19.9c1.1,0,2,0.9,2,2v23.8   C205.4,116.8,204.5,117.7,203.4,117.7z").attr({fill: '#42B4B9',parent: 'Scotland','stroke-width': '0','stroke-opacity': '1'}).data('id', 'path_aj');
var path_ak = rsr.path("M172.6,80.9h-5.7c-1.1,0-2-0.9-2-2V65.4c0-1.1,0.9-2,2-2h5.7c1.1,0,2,0.9,2,2v13.5   C174.6,80,173.7,80.9,172.6,80.9z").attr({fill: '#42B4B9',parent: 'Scotland','stroke-width': '0','stroke-opacity': '1'}).data('id', 'path_ak');
var path_al = rsr.path("M225.3,88.9h-16.8c-1.1,0-2-0.9-2-2v-22c0-1.1,0.9-2,2-2h16.8c1.1,0,2,0.9,2,2v22   C227.3,88,226.4,88.9,225.3,88.9z").attr({fill: '#42B4B9',parent: 'Scotland','stroke-width': '0','stroke-opacity': '1'}).data('id', 'path_al');
var path_am = rsr.path("M254.5,117.7h-24c-1.1,0-2-0.9-2-2V91.9c0-1.1,0.9-2,2-2h24c1.1,0,2,0.9,2,2v23.8   C256.5,116.8,255.6,117.7,254.5,117.7z").attr({fill: '#42B4B9',parent: 'Scotland','stroke-width': '0','stroke-opacity': '1'}).data('id', 'path_am');
var path_an = rsr.path("M278.2,131.9h-18.4c-1.1,0-2-0.9-2-2v-9.2c0-1.1,0.9-2,2-2h18.4c1.1,0,2,0.9,2,2v9.2   C280.2,131,279.3,131.9,278.2,131.9z").attr({fill: '#42B4B9',parent: 'Scotland','stroke-width': '0','stroke-opacity': '1'}).data('id', 'path_an');
var path_ao = rsr.path("M254.5,145.1h-24c-1.1,0-2-0.9-2-2v-22.4c0-1.1,0.9-2,2-2h24c1.1,0,2,0.9,2,2v22.4   C256.5,144.2,255.6,145.1,254.5,145.1z").attr({fill: '#42B4B9',parent: 'Scotland','stroke-width': '0','stroke-opacity': '1'}).data('id', 'path_ao');
var path_ap = rsr.path("M225.3,117.7h-16.8c-1.1,0-2-0.9-2-2V91.9c0-1.1,0.9-2,2-2h16.8c1.1,0,2,0.9,2,2v23.8   C227.3,116.8,226.4,117.7,225.3,117.7z").attr({fill: '#42B4B9',parent: 'Scotland','stroke-width': '0','stroke-opacity': '1'}).data('id', 'path_ap');
var path_aq = rsr.path("M253.2,88.9h-22.8c-1.1,0-2-0.9-2-2v-22c0-1.1,0.9-2,2-2h22.8c1.1,0,2,0.9,2,2v22   C255.2,88,254.3,88.9,253.2,88.9z").attr({fill: '#42B4B9',parent: 'Scotland','stroke-width': '0','stroke-opacity': '1'}).data('id', 'path_aq');
var path_ar = rsr.path("M248.5,37.1h-18.1c-1.1,0-2-0.9-2-2V12.9c0-1.1,0.9-2,2-2h18.1c1.1,0,2,0.9,2,2v22.2   C250.5,36.2,249.6,37.1,248.5,37.1z").attr({fill: '#42B4B9',parent: 'Scotland','stroke-width': '0','stroke-opacity': '1'}).data('id', 'path_ar');
var path_as = rsr.path("M271.6,61.8H258c-1.1,0-2-0.9-2-2V46.1c0-1.1,0.9-2,2-2h13.6c1.1,0,2,0.9,2,2v13.7   C273.6,60.9,272.7,61.8,271.6,61.8z").attr({fill: '#42B4B9',parent: 'Scotland','stroke-width': '0','stroke-opacity': '1'}).data('id', 'path_as');
var path_at = rsr.path("M272,83.7h-13.6c-1.1,0-2-0.9-2-2V64.9c0-1.1,0.9-2,2-2H272c1.1,0,2,0.9,2,2v16.8   C274,82.8,273.1,83.7,272,83.7z").attr({fill: '#42B4B9',parent: 'Scotland','stroke-width': '0','stroke-opacity': '1'}).data('id', 'path_at');
var path_au = rsr.path("M173.4,37.1h-6.6c-1.1,0-2-0.9-2-2v-9.3c0-1.1,0.9-2,2-2h6.6c1.1,0,2,0.9,2,2v9.3   C175.4,36.2,174.5,37.1,173.4,37.1z").attr({fill: '#42B4B9',parent: 'Scotland','stroke-width': '0','stroke-opacity': '1'}).data('id', 'path_au');
var path_av = rsr.path("M225.3,145.1h-16.8c-1.1,0-2-0.9-2-2v-22.4c0-1.1,0.9-2,2-2h16.8c1.1,0,2,0.9,2,2v22.4   C227.3,144.2,226.4,145.1,225.3,145.1z").attr({fill: '#42B4B9',parent: 'Scotland','stroke-width': '0','stroke-opacity': '1'}).data('id', 'path_av');
var path_aw = rsr.path("M225.3,167h-16.8c-1.1,0-2-0.9-2-2v-16.4c0-1.1,0.9-2,2-2h16.8c1.1,0,2,0.9,2,2V165   C227.3,166.1,226.4,167,225.3,167z").attr({fill: '#42B4B9',parent: 'Scotland','stroke-width': '0','stroke-opacity': '1'}).data('id', 'path_aw');
var path_ax = rsr.path("M203.4,166.2h-8.9c-1.1,0-2-0.9-2-2v-15.6c0-1.1,0.9-2,2-2h8.9c1.1,0,2,0.9,2,2v15.6   C205.4,165.3,204.5,166.2,203.4,166.2z").attr({fill: '#42B4B9',parent: 'Scotland','stroke-width': '0','stroke-opacity': '1'}).data('id', 'path_ax');
var path_ay = rsr.path("M161.5,37.1h-8.2c-1.1,0-2-0.9-2-2V26c0-1.1,0.9-2,2-2h8.2c1.1,0,2,0.9,2,2v9.1   C163.5,36.2,162.6,37.1,161.5,37.1z").attr({fill: '#42B4B9',parent: 'Scotland','stroke-width': '0','stroke-opacity': '1'}).data('id', 'path_ay');
var path_az = rsr.path("M203.4,144.9h-19.9c-1.1,0-2-0.9-2-2v-22.1c0-1.1,0.9-2,2-2h19.9c1.1,0,2,0.9,2,2v22.1   C205.4,144,204.5,144.9,203.4,144.9z").attr({fill: '#42B4B9',parent: 'Scotland','stroke-width': '0','stroke-opacity': '1'}).data('id', 'path_az');
var path_ba = rsr.path("M177.8,134.8h-10.3c-1.1,0-2-0.9-2-2v-11.6c0-1.1,0.9-2,2-2h10.3c1.1,0,2,0.9,2,2v11.6   C179.8,133.9,178.9,134.8,177.8,134.8z").attr({fill: '#42B4B9',parent: 'Scotland','stroke-width': '0','stroke-opacity': '1'}).data('id', 'path_ba');
var path_bb = rsr.path("M177.8,117.7h-3.7c-1.1,0-2-0.9-2-2v-15.5c0-1.1,0.9-2,2-2h3.7c1.1,0,2,0.9,2,2v15.5   C179.8,116.8,178.9,117.7,177.8,117.7z").attr({fill: '#42B4B9',parent: 'Scotland','stroke-width': '0','stroke-opacity': '1'}).data('id', 'path_bb');
Scotland.attr({'id': 'Scotland','name': 'Scotland'});
var Wales = rsr.set();
var path_bc = rsr.path("M227.1,231.8h-8.9c-1.1,0-2-0.9-2-2v-9.6c0-1.1,0.9-2,2-2h8.9c1.1,0,2,0.9,2,2v9.6   C229.1,230.9,228.2,231.8,227.1,231.8z").attr({fill: '#42B4B9',parent: 'Wales','stroke-width': '0','stroke-opacity': '1'}).data('id', 'path_bc');
var path_bd = rsr.path("M216.1,299.2h-10.4c-1.1,0-2-0.9-2-2v-6c0-1.1,0.9-2,2-2h10.4c1.1,0,2,0.9,2,2v6   C218.1,298.3,217.2,299.2,216.1,299.2z").attr({fill: '#42B4B9',parent: 'Wales','stroke-width': '0','stroke-opacity': '1'}).data('id', 'path_bd');
var path_be = rsr.path("M227.7,259.2h-19.2c-1.1,0-2-0.9-2-2v-20.7c0-1.1,0.9-2,2-2h19.2c1.1,0,2,0.9,2,2v20.7   C229.7,258.3,228.8,259.2,227.7,259.2z").attr({fill: '#42B4B9',parent: 'Wales','stroke-width': '0','stroke-opacity': '1'}).data('id', 'path_be');
var path_bf = rsr.path("M227.7,287.5h-22c-1.1,0-2-0.9-2-2v-22.2c0-1.1,0.9-2,2-2h22c1.1,0,2,0.9,2,2v22.2   C229.7,286.6,228.8,287.5,227.7,287.5z").attr({fill: '#42B4B9',parent: 'Wales','stroke-width': '0','stroke-opacity': '1'}).data('id', 'path_bf');
var path_bg = rsr.path("M199.2,299.2h-17.4c-1.1,0-2-0.9-2-2v-6c0-1.1,0.9-2,2-2h17.4c1.1,0,2,0.9,2,2v6   C201.2,298.3,200.3,299.2,199.2,299.2z").attr({fill: '#42B4B9',parent: 'Wales','stroke-width': '0','stroke-opacity': '1'}).data('id', 'path_bg');
var path_bh = rsr.path("M199.2,287.5h-25.1c-1.1,0-2-0.9-2-2v-15.2c0-1.1,0.9-2,2-2h25.1c1.1,0,2,0.9,2,2v15.2   C201.2,286.6,200.3,287.5,199.2,287.5z").attr({fill: '#42B4B9',parent: 'Wales','stroke-width': '0','stroke-opacity': '1'}).data('id', 'path_bh');
var path_bi = rsr.path("M227.7,308.5h-5.4c-1.1,0-2-0.9-2-2v-15.3c0-1.1,0.9-2,2-2h5.4c1.1,0,2,0.9,2,2v15.3   C229.7,307.6,228.8,308.5,227.7,308.5z").attr({fill: '#42B4B9',parent: 'Wales','stroke-width': '0','stroke-opacity': '1'}).data('id', 'path_bi');
var path_bj = rsr.path("M241.3,259.2h-7.2c-1.1,0-2-0.9-2-2v-21.4c0-1.1,0.9-2,2-2h7.2c1.1,0,2,0.9,2,2v21.4   C243.3,258.3,242.4,259.2,241.3,259.2z").attr({fill: '#42B4B9',parent: 'Wales','stroke-width': '0','stroke-opacity': '1'}).data('id', 'path_bj');
var path_bk = rsr.path("M241.3,231.8h-7.2c-1.1,0-2-0.9-2-2v-22.3c0-1.1,0.9-2,2-2h7.2c1.1,0,2,0.9,2,2v22.3   C243.3,230.9,242.4,231.8,241.3,231.8z").attr({fill: '#42B4B9',parent: 'Wales','stroke-width': '0','stroke-opacity': '1'}).data('id', 'path_bk');
var path_bl = rsr.path("M241.3,287.5h-7.2c-1.1,0-2-0.9-2-2v-22.1c0-1.1,0.9-2,2-2h7.2c1.1,0,2,0.9,2,2v22.1   C243.3,286.6,242.4,287.5,241.3,287.5z").attr({fill: '#42B4B9',parent: 'Wales','stroke-width': '0','stroke-opacity': '1'}).data('id', 'path_bl');
Wales.attr({'id': 'Wales','name': 'Wales'});
var North_East = rsr.set();
var path_bm = rsr.path("M281.4,176.1h-21.5c-1.1,0-2-0.9-2-2v-25.5c0-1.1,0.9-2,2-2h21.5c1.1,0,2,0.9,2,2v25.5   C283.4,175.2,282.5,176.1,281.4,176.1z").attr({fill: '#61AA95',parent: 'North_East','stroke-width': '0','stroke-opacity': '1'}).data('id', 'path_bm');
var path_bn = rsr.path("M281.4,188.7h-21.5c-1.1,0-2-0.9-2-2v-7.1c0-1.1,0.9-2,2-2h21.5c1.1,0,2,0.9,2,2v7.1   C283.4,187.8,282.5,188.7,281.4,188.7z").attr({fill: '#61AA95',parent: 'North_East','stroke-width': '0','stroke-opacity': '1'}).data('id', 'path_bn');
var path_bo = rsr.path("M281.6,145.1h-21.7c-1.1,0-2-0.9-2-2v-7.7c0-1.1,0.9-2,2-2h21.7c1.1,0,2,0.9,2,2v7.7   C283.6,144.2,282.7,145.1,281.6,145.1z").attr({fill: '#61AA95',parent: 'North_East','stroke-width': '0','stroke-opacity': '1'}).data('id', 'path_bo');
North_East.attr({'id': 'North_East','name': 'North_East'});
var South_West = rsr.set();
var path_bp = rsr.path("M254.5,315h-21.3c-1.1,0-2-0.9-2-2v-21.8c0-1.1,0.9-2,2-2h21.3c1.1,0,2,0.9,2,2V313   C256.5,314.1,255.6,315,254.5,315z").attr({fill: '#2AB194',parent: 'South_West','stroke-width': '0','stroke-opacity': '1'}).data('id', 'path_bp');
var path_bq = rsr.path("M254.7,362h-22.2c-1.1,0-2-0.9-2-2v-22.6c0-1.1,0.9-2,2-2h22.2c1.1,0,2,0.9,2,2V360   C256.7,361.1,255.8,362,254.7,362z").attr({fill: '#2AB194',parent: 'South_West','stroke-width': '0','stroke-opacity': '1'}).data('id', 'path_bq');
var path_br = rsr.path("M226.6,362.1h-22c-1.1,0-2-0.9-2-2v-22.6c0-1.1,0.9-2,2-2h22c1.1,0,2,0.9,2,2v22.6   C228.6,361.2,227.7,362.1,226.6,362.1z").attr({fill: '#28B094',parent: 'South_West','stroke-width': '0','stroke-opacity': '1'}).data('id', 'path_br');
var path_bs = rsr.path("M220.8,376.8h-16.1c-1.1,0-2-0.9-2-2v-9.3c0-1.1,0.9-2,2-2h16.1c1.1,0,2,0.9,2,2v9.3   C222.8,375.9,221.9,376.8,220.8,376.8z").attr({fill: '#28B094',parent: 'South_West','stroke-width': '0','stroke-opacity': '1'}).data('id', 'path_bs');
var path_bt = rsr.path("M181.4,376.1H167c-1.1,0-2-0.9-2-2v-9.3c0-1.1,0.9-2,2-2h14.4c1.1,0,2,0.9,2,2v9.3   C183.4,375.2,182.5,376.1,181.4,376.1z").attr({fill: '#28B094',parent: 'South_West','stroke-width': '0','stroke-opacity': '1'}).data('id', 'path_bt');
var path_bu = rsr.path("M198.7,362H188c-1.1,0-2-0.9-2-2v-9.3c0-1.1,0.9-2,2-2h10.7c1.1,0,2,0.9,2,2v9.3   C200.7,361.1,199.8,362,198.7,362z").attr({fill: '#28B094',parent: 'South_West','stroke-width': '0','stroke-opacity': '1'}).data('id', 'path_bu');
var path_bv = rsr.path("M181.4,389.7H167c-1.1,0-2-0.9-2-2v-8.1c0-1.1,0.9-2,2-2h14.4c1.1,0,2,0.9,2,2v8.1   C183.4,388.8,182.5,389.7,181.4,389.7z").attr({fill: '#28B094',parent: 'South_West','stroke-width': '0','stroke-opacity': '1'}).data('id', 'path_bv');
var path_bw = rsr.path("M161.4,389.7h-14.9c-1.1,0-2-0.9-2-2v-8.1c0-1.1,0.9-2,2-2h14.9c1.1,0,2,0.9,2,2v8.1   C163.4,388.8,162.5,389.7,161.4,389.7z").attr({fill: '#28B094',parent: 'South_West','stroke-width': '0','stroke-opacity': '1'}).data('id', 'path_bw');
var path_bx = rsr.path("M198.7,389.7H188c-1.1,0-2-0.9-2-2v-8.1c0-1.1,0.9-2,2-2h10.7c1.1,0,2,0.9,2,2v8.1   C200.7,388.8,199.8,389.7,198.7,389.7z").attr({fill: '#28B094',parent: 'South_West','stroke-width': '0','stroke-opacity': '1'}).data('id', 'path_bx');
var path_by = rsr.path("M198.1,376.1h-10.7c-1.1,0-2-0.9-2-2v-8.5c0-1.1,0.9-2,2-2h10.7c1.1,0,2,0.9,2,2v8.5   C200.1,375.2,199.2,376.1,198.1,376.1z").attr({fill: '#28B094',parent: 'South_West','stroke-width': '0','stroke-opacity': '1'}).data('id', 'path_by');
var path_bz = rsr.path("M254.7,333.4h-21.3c-1.1,0-2-0.9-2-2v-12.7c0-1.1,0.9-2,2-2h21.3c1.1,0,2,0.9,2,2v12.7   C256.7,332.5,255.8,333.4,254.7,333.4z").attr({fill: '#2AB194',parent: 'South_West','stroke-width': '0','stroke-opacity': '1'}).data('id', 'path_bz');
South_West.attr({'id': 'South_West','name': 'South_West'});
var South_East = rsr.set();
var path_ca = rsr.path("M281.6,315h-21.3c-1.1,0-2-0.9-2-2v-21.9c0-1.1,0.9-2,2-2h21.3c1.1,0,2,0.9,2,2V313   C283.6,314.1,282.7,315,281.6,315z").attr({fill: '#7DA89F',parent: 'South_East','stroke-width': '0','stroke-opacity': '1'}).data('id', 'path_ca');
var path_cb = rsr.path("M281.4,362h-21c-1.1,0-2-0.9-2-2v-22.5c0-1.1,0.9-2,2-2h21c1.1,0,2,0.9,2,2V360   C283.4,361.1,282.5,362,281.4,362z").attr({fill: '#7DA89F',parent: 'South_East','stroke-width': '0','stroke-opacity': '1'}).data('id', 'path_cb');
var path_cc = rsr.path("M308.8,362h-21.7c-1.1,0-2-0.9-2-2v-22.5c0-1.1,0.9-2,2-2h21.7c1.1,0,2,0.9,2,2V360   C310.8,361.1,309.9,362,308.8,362z").attr({fill: '#7DA89F',parent: 'South_East','stroke-width': '0','stroke-opacity': '1'}).data('id', 'path_cc');
var path_cd = rsr.path("M336.6,362.1h-22c-1.1,0-2-0.9-2-2v-22.7c0-1.1,0.9-2,2-2h22c1.1,0,2,0.9,2,2v22.7   C338.6,361.2,337.7,362.1,336.6,362.1z").attr({fill: '#7DA89F',parent: 'South_East','stroke-width': '0','stroke-opacity': '1'}).data('id', 'path_cd');
var path_ce = rsr.path("M350.6,362H342c-1.1,0-2-0.9-2-2v-22.5c0-1.1,0.9-2,2-2h8.7c1.1,0,2,0.9,2,2V360   C352.6,361.1,351.7,362,350.6,362z").attr({fill: '#7DA89F',parent: 'South_East','stroke-width': '0','stroke-opacity': '1'}).data('id', 'path_ce');
var path_cf = rsr.path("M364.4,362h-8c-1.1,0-2-0.9-2-2v-9.3c0-1.1,0.9-2,2-2h8c1.1,0,2,0.9,2,2v9.3   C366.4,361.1,365.5,362,364.4,362z").attr({fill: '#7DA89F',parent: 'South_East','stroke-width': '0','stroke-opacity': '1'}).data('id', 'path_cf');
var path_cg = rsr.path("M281.7,333.4h-21.3c-1.1,0-2-0.9-2-2v-12.7c0-1.1,0.9-2,2-2h21.3c1.1,0,2,0.9,2,2v12.7   C283.7,332.5,282.8,333.4,281.7,333.4z").attr({fill: '#7DA89F',parent: 'South_East','stroke-width': '0','stroke-opacity': '1'}).data('id', 'path_cg');
South_East.attr({'id': 'South_East','name': 'South_East'});
var London = rsr.set();
var path_ch = rsr.path("M308.9,333.4h-21.8c-1.1,0-2-0.9-2-2v-12.7c0-1.1,0.9-2,2-2h21.8c1.1,0,2,0.9,2,2v12.7   C310.9,332.5,310,333.4,308.9,333.4z").attr({fill: '#48BDCE',parent: 'London','stroke-width': '0','stroke-opacity': '1'}).data('id', 'path_ch');
London.attr({'id': 'London','name': 'London'});
var Yorkshire = rsr.set();
var path_ci = rsr.path("M308.5,231.8h-21.6c-1.1,0-2-0.9-2-2v-22.2c0-1.1,0.9-2,2-2h21.6c1.1,0,2,0.9,2,2v22.2   C310.5,230.9,309.6,231.8,308.5,231.8z").attr({fill: '#3EB498',parent: 'Yorkshire','stroke-width': '0','stroke-opacity': '1'}).data('id', 'path_ci');
var path_cj = rsr.path("M281.4,232.1h-21.5c-1.1,0-2-0.9-2-2v-22.5c0-1.1,0.9-2,2-2h21.5c1.1,0,2,0.9,2,2v22.5   C283.4,231.2,282.5,232.1,281.4,232.1z").attr({fill: '#3EB498',parent: 'Yorkshire','stroke-width': '0','stroke-opacity': '1'}).data('id', 'path_cj');
var path_ck = rsr.path("M294.1,203.9h-7.2c-1.1,0-2-0.9-2-2v-22.3c0-1.1,0.9-2,2-2h7.2c1.1,0,2,0.9,2,2v22.3   C296.1,203,295.2,203.9,294.1,203.9z").attr({fill: '#3EB498',parent: 'Yorkshire','stroke-width': '0','stroke-opacity': '1'}).data('id', 'path_ck');
var path_cl = rsr.path("M281.5,203.9h-21.5c-1.1,0-2-0.9-2-2v-9.8c0-1.1,0.9-2,2-2h21.5c1.1,0,2,0.9,2,2v9.8   C283.5,203,282.6,203.9,281.5,203.9z").attr({fill: '#3DB397',parent: 'Yorkshire','stroke-width': '0','stroke-opacity': '1'}).data('id', 'path_cl');
Yorkshire.attr({'id': 'Yorkshire','name': 'Yorkshire'});
var East = rsr.set();
var path_cm = rsr.path("M308.7,315h-21.8c-1.1,0-2-0.9-2-2v-21.8c0-1.1,0.9-2,2-2h21.8c1.1,0,2,0.9,2,2V313   C310.7,314.1,309.8,315,308.7,315z").attr({fill: '#3DB397',parent: 'East','stroke-width': '0','stroke-opacity': '1'}).data('id', 'path_cm');
var path_cn = rsr.path("M337.6,315h-23.2c-1.1,0-2-0.9-2-2v-21.9c0-1.1,0.9-2,2-2h23.2c1.1,0,2,0.9,2,2V313   C339.6,314.1,338.7,315,337.6,315z").attr({fill: '#3DB397',parent: 'East','stroke-width': '0','stroke-opacity': '1'}).data('id', 'path_cn');
var path_co = rsr.path("M351.6,300.9H343c-1.1,0-2-0.9-2-2v-7.7c0-1.1,0.9-2,2-2h8.7c1.1,0,2,0.9,2,2v7.7   C353.6,300,352.7,300.9,351.6,300.9z").attr({fill: '#3DB397',parent: 'East','stroke-width': '0','stroke-opacity': '1'}).data('id', 'path_co');
var path_cp = rsr.path("M351.6,315H343c-1.1,0-2-0.9-2-2v-8.9c0-1.1,0.9-2,2-2h8.7c1.1,0,2,0.9,2,2v8.9   C353.6,314.1,352.7,315,351.6,315z").attr({fill: '#3DB397',parent: 'East','stroke-width': '0','stroke-opacity': '1'}).data('id', 'path_cp');
var path_cq = rsr.path("M325.1,333.4h-10.6c-1.1,0-2-0.9-2-2v-12.7c0-1.1,0.9-2,2-2h10.6c1.1,0,2,0.9,2,2v12.7   C327.1,332.5,326.2,333.4,325.1,333.4z").attr({fill: '#3DB397',parent: 'East','stroke-width': '0','stroke-opacity': '1'}).data('id', 'path_cq');
var path_cr = rsr.path("M337.6,287.6h-8.5c-1.1,0-2-0.9-2-2v-7.7c0-1.1,0.9-2,2-2h8.5c1.1,0,2,0.9,2,2v7.7   C339.6,286.7,338.7,287.6,337.6,287.6z").attr({fill: '#3DB397',parent: 'East','stroke-width': '0','stroke-opacity': '1'}).data('id', 'path_cr');
var path_cs = rsr.path("M323.6,287.6h-9c-1.1,0-2-0.9-2-2v-7.7c0-1.1,0.9-2,2-2h9c1.1,0,2,0.9,2,2v7.7   C325.6,286.7,324.7,287.6,323.6,287.6z").attr({fill: '#3DB397',parent: 'East','stroke-width': '0','stroke-opacity': '1'}).data('id', 'path_cs');
East.attr({'id': 'East','name': 'East'});


var rsrGroups = [Isle_of_Man_1_,North_West,Midlands,Northern_Ireland,Ireland,Scotland,Wales,North_East,South_West,South_East,London,Yorkshire,East];
Isle_of_Man_1_.push(
	Isle_of_Man 
);
North_West.push(
	path_a ,
	path_b ,
	path_c 
);
Midlands.push(
	path_d ,
	path_e ,
	path_f ,
	path_g ,
	path_h ,
	path_i ,
	path_j 
);
Northern_Ireland.push(
	path_k ,
	path_l ,
	path_m ,
	path_n ,
	path_o ,
	path_p 
);
Ireland.push(
	path_q ,
	path_r ,
	path_s ,
	path_t ,
	path_u ,
	path_v ,
	path_w ,
	path_x ,
	path_y ,
	path_z ,
	path_aa ,
	path_ab ,
	path_ac 
);
Scotland.push(
	path_ad ,
	path_ae ,
	path_af ,
	path_ag ,
	path_ah ,
	path_ai ,
	path_aj ,
	path_ak ,
	path_al ,
	path_am ,
	path_an ,
	path_ao ,
	path_ap ,
	path_aq ,
	path_ar ,
	path_as ,
	path_at ,
	path_au ,
	path_av ,
	path_aw ,
	path_ax ,
	path_ay ,
	path_az ,
	path_ba ,
	path_bb 
);
Wales.push(
	path_bc ,
	path_bd ,
	path_be ,
	path_bf ,
	path_bg ,
	path_bh ,
	path_bi ,
	path_bj ,
	path_bk ,
	path_bl 
);
North_East.push(
	path_bm ,
	path_bn ,
	path_bo 
);
South_West.push(
	path_bp ,
	path_bq ,
	path_br ,
	path_bs ,
	path_bt ,
	path_bu ,
	path_bv ,
	path_bw ,
	path_bx ,
	path_by ,
	path_bz 
);
South_East.push(
	path_ca ,
	path_cb ,
	path_cc ,
	path_cd ,
	path_ce ,
	path_cf ,
	path_cg 
);
London.push(
	path_ch 
);
Yorkshire.push(
	path_ci ,
	path_cj ,
	path_ck ,
	path_cl 
);
East.push(
	path_cm ,
	path_cn ,
	path_co ,
	path_cp ,
	path_cq ,
	path_cr ,
	path_cs 
);
	
	
	
	
	
//MAIN
//loop through each group
for(var x=0;x<rsrGroups.length;x++){
    var group = rsrGroups[x];
    //each group has individual boxes - loop them and colour them
    $.each(group, function(i, val) {
                
        var elem = group[i];
        //hover
        group.mouseover(mouse_in(elem, group));  
        group.mouseout(mouse_out(elem));
        
        //click
        group.click(mouse_click(elem,group));
    });

}


//ON MOUSE HOVER
var colour='';
var selection="";
function mouse_in(elem, group) {

    return function() {
                            
                setTexts(group)  
                
                 elem.node.style.opacity= 0.7
                 colour= elem.attrs.fill
                // elem.node.setAttribute('fill','#21ddbb');  
                 elem.node.setAttribute('stroke','#fff');                    
                 elem.node.setAttribute('stroke-width','2');   
                 elem.node.style.cursor= "pointer"
           };
}
//ON MOUSE OUT
function mouse_out(elem) {
    return function() {
                 elem.node.style.opacity= 1
                 //elem.node.setAttribute('fill',colour);  
                 elem.node.setAttribute('stroke-width','0');   
                 $('#selection').empty()

           };
}

//ON MOUSE CLICK
var highlightColour='#21ddbb';
function mouse_click(elem,group){
    return function(){
        var col = elem.node.getAttribute('fill')

        if(col==highlightColour){
            elem.node.setAttribute('fill',elem.attrs.fill);  
            setSelected(group, 'off');
            
        }
        else{
            elem.node.setAttribute('fill',highlightColour);  
            elem.node.setAttribute('stroke-width','1');
            setSelected(group, 'on');
        }
    };
}

function setTexts(group){
    if(group == Isle_of_Man_1_) 
            selection="Isle of Man"
    else if(group == North_West) 
        selection="North West"
    else if(group==Midlands) 
            selection="Midlands"
    else if(group == Northern_Ireland)
            selection="Northern Ireland"
    else if (group == Ireland)
            selection="Ireland"
    else if(group == Scotland)
            selection="Scotland"
    else if(group == Wales) 
            selection="Wales"
    else if(group == North_East) 
            selection="North East"
    else if(group == South_West) 
            selection="South West"
    else if(group == South_East)
            selection="South East"
    else if(group == London) 
            selection="London"
    else if(group == Yorkshire) 
            selection="Yorkshire"
    else if(group==East)
            selection="East"
        
    $('#selection').text(selection)
}


var selected='';
var places = [];
function setSelected(group, toggle){
        if(group == Isle_of_Man_1_) 
          selected='Isle of Man'
    else if(group == North_West) 
        selected="North West"
    else if(group==Midlands) 
            selected="Midlands"
    else if(group == Northern_Ireland)
            selected="Northern Ireland"
    else if (group == Ireland)
            selected="Ireland"
    else if(group == Scotland)
            selected="Scotland"
    else if(group == Wales) 
            selected="Wales"
    else if(group == North_East) 
            selected="North East"
    else if(group == South_West) 
            selected="South West"
    else if(group == South_East)
            selected="South East"
    else if(group == London) 
            selected="London"
    else if(group == Yorkshire) 
            selected="Yorkshire"
    else if(group==East)
            selected="East"
        
if(toggle=='on'){

    if ($.inArray(selected, places) == -1)
    {
      places.push(selected)
      var tag_list = '';
      
      for(var x=0;x<places.length;x++){
          tag_list+='<span class="tag-selected"><input type="hidden" name="Location[]" value="'+places[x]+'">'+places[x]+'</span>'
      }
      
      $('#selected').empty().append(tag_list);
    }
}
if(toggle=='off'){
    if ($.inArray(selected, places) !== -1)
    {
        removeA(places,selected)
      var tag_list = '';
      
      for(var x=0;x<places.length;x++){
          tag_list+='<span class="tag-selected"><input type="hidden" name="Location[]" value="'+places[x]+'">'+places[x]+'</span>'
      }
      
      $('#selected').empty().append(tag_list);
    if($.trim($('#selected').text()) == "") {
      $('#selected').empty().append('<span class="nowhere">Nothing</span>');
    }
    }

}
     
}

//Remove element from array
function removeA(arr){
var what, a= arguments, L= a.length, ax;
while(L> 1 && arr.length){
    what= a[--L];
    while((ax= arr.indexOf(what))!= -1){
        arr.splice(ax, 1);
    }
}
return arr;
}

