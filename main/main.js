(function (lib, img, cjs) {

var p; // shortcut to reference prototypes

// stage content:
(lib.main = function(mode,startPosition,loop) {
if (loop == null) { loop = false; }	this.initialize(mode,startPosition,loop,{});

	// 圖層 4
	this.instance = new lib.ani22();
	this.instance.setTransform(499.8,343.4,0.95,0.95);
	this.instance._off = true;

	this.timeline.addTween(cjs.Tween.get(this.instance).wait(9).to({_off:false},0).to({y:639.3},10).to({y:627.5},2).wait(6));

	// 圖層 1
	this.instance_1 = new lib.ani1("synched",0);
	this.instance_1.setTransform(481.8,1533.7);
	this.instance_1.alpha = 0;

	this.timeline.addTween(cjs.Tween.get(this.instance_1).to({y:645.5,alpha:1},14).wait(13));

}).prototype = p = new cjs.MovieClip();
p.nominalBounds = new cjs.Rectangle(214,150.9,477.3,378.6);


// symbols:
(lib.gamelogo = function() {
	this.initialize(img.gamelogo);
}).prototype = p = new cjs.Bitmap();
p.nominalBounds = new cjs.Rectangle(0,0,398,298);


(lib.gamelogo_1 = function() {
	this.initialize(img.gamelogo_1);
}).prototype = p = new cjs.Bitmap();
p.nominalBounds = new cjs.Rectangle(0,0,398,298);


(lib.mainci = function() {
	this.initialize(img.mainci);
}).prototype = p = new cjs.Bitmap();
p.nominalBounds = new cjs.Rectangle(0,0,829,1271);


(lib.元件3 = function() {
	this.initialize();

	// 圖層 1
	this.shape = new cjs.Shape();
	this.shape.graphics.f("#FFFCFA").s().p("AggBaQgYgDgVgZQgWgZgMg2QgMg4AdAQQAcAQAogDQAmgEBBggQBAgggsBTQgsBSgfAUQgaARgWAAIgGAAg");
	this.shape.setTransform(11.6,9);

	this.addChild(this.shape);
}).prototype = p = new cjs.Container();
p.nominalBounds = new cjs.Rectangle(0,0,23.2,18.1);


(lib.元件2 = function() {
	this.initialize();

	// 圖層 1
	this.shape = new cjs.Shape();
	this.shape.graphics.f("#010604").s().p("AgnAqQgQgSAAgYQAAgXAQgTQARgRAWAAQAXAAAQARQARATAAAXQAAAYgRASQgQASgXAAQgWAAgRgSg");
	this.shape.setTransform(5.7,6.1);

	this.addChild(this.shape);
}).prototype = p = new cjs.Container();
p.nominalBounds = new cjs.Rectangle(0,0,11.3,12.1);


(lib.元件1 = function() {
	this.initialize();

	// 圖層 1
	this.shape = new cjs.Shape();
	this.shape.graphics.f().s("#010604").ss(1,1,1).p("AiTgiQB6CMCtiM");
	this.shape.setTransform(14.8,3.6);

	this.shape_1 = new cjs.Shape();
	this.shape_1.graphics.f("#30BFFA").s().p("AiTgiQCZBFCOhFQhXBFhJAAQhKAAg9hFg");
	this.shape_1.setTransform(14.8,3.6);

	this.addChild(this.shape_1,this.shape);
}).prototype = p = new cjs.Container();
p.nominalBounds = new cjs.Rectangle(0,0,29.7,7.1);


(lib.ani1 = function() {
	this.initialize();

	// 圖層 1
	this.instance = new lib.mainci();
	this.instance.setTransform(-261.3,-583.6,0.95,0.95);

	this.addChild(this.instance);
}).prototype = p = new cjs.Container();
p.nominalBounds = new cjs.Rectangle(-261.3,-583.6,787.6,1207.5);


(lib.ani5 = function() {
	this.initialize();

	// 圖層 1
	this.instance = new lib.gamelogo_1();
	this.instance.setTransform(-179,-134,0.9,0.9);

	this.addChild(this.instance);
}).prototype = p = new cjs.Container();
p.nominalBounds = new cjs.Rectangle(-179,-134,358.2,268.2);


(lib.補間動畫1 = function() {
	this.initialize();

	// 圖層 1
	this.instance = new lib.元件1();
	this.instance.setTransform(-0.1,0.2,1,1,0,0,0,14.8,3.6);

	this.shape = new cjs.Shape();
	this.shape.graphics.f().s("#010604").ss(1,1,1).p("ACbABIgJAAQACgBACAAAiaAAIAGAB");
	this.shape.setTransform(0,-3.5);

	this.addChild(this.shape,this.instance);
}).prototype = p = new cjs.Container();
p.nominalBounds = new cjs.Rectangle(-15.5,-3.7,31.1,7.5);


(lib.ani22 = function(mode,startPosition,loop) {
	this.initialize(mode,startPosition,loop,{});

	// 圖層 2
	/* Layers with classic tweens must contain only a single symbol instance. */

	// 圖層 3
	this.shape = new cjs.Shape();
	this.shape.graphics.f("#30BFFA").s().p("AiMAKQgfg9AZgVQB1BwC0hiIAHACIgNBIQhRA5hEAAQhKAAg+g/g");
	this.shape.setTransform(-218.3,-589.6);

	this.shape_1 = new cjs.Shape();
	this.shape_1.graphics.f("#30BFFA").s().p("AilgJQgMhJAYgVQB2BwC0hhIAHABQAvAxhNBXQhsA3hCAAQhiAAgPhxg");
	this.shape_1.setTransform(-217.7,-586.6);

	this.shape_2 = new cjs.Shape();
	this.shape_2.graphics.f("#30BFFA").s().p("AiRA1Qg+ihBGgeQB1ByC0hkIAHABQAeBdhSBlQheBEg+AAQhHAAghhWg");
	this.shape_2.setTransform(-219.2,-583);

	this.shape_3 = new cjs.Shape();
	this.shape_3.graphics.f("#30BFFA").s().p("AikACQgNhHAZgVQB1BxC0hiIAHABQAwAxhTBAQhoA0hBAAQhYAAgYhZg");
	this.shape_3.setTransform(-217.7,-587.9);

	this.shape_4 = new cjs.Shape();
	this.shape_4.graphics.f("#30BFFA").s().p("AiYgzIABAAQB1BwC0hiIAHABIgYAkQg4A0g6AAQhRAAhWhng");
	this.shape_4.setTransform(-217.8,-591.7);

	this.timeline.addTween(cjs.Tween.get({}).to({state:[]}).to({state:[]},1).to({state:[{t:this.shape}]},6).to({state:[{t:this.shape_1}]},1).to({state:[{t:this.shape_2}]},1).to({state:[{t:this.shape_3}]},2).to({state:[{t:this.shape_4}]},1).to({state:[]},1).wait(138));

	// 圖層 5
	this.shape_5 = new cjs.Shape();
	this.shape_5.graphics.f("rgba(84,84,84,0.498)").s().p("Ah8AEIAJglQB3BBB5hWIAAA1QhOA4g+AAQg8AAgxgzg");
	this.shape_5.setTransform(-217.2,-588);

	this.timeline.addTween(cjs.Tween.get({}).to({state:[{t:this.shape_5}]}).wait(151));

	// 圖層 4
	this.instance = new lib.元件2();
	this.instance.setTransform(-219,-582.7,1,1,0,0,0,5.7,6);

	this.timeline.addTween(cjs.Tween.get(this.instance).wait(43).to({x:-223.9,y:-584.9},6).wait(14).to({x:-218.9,y:-582.6},6).to({x:-210.8,y:-585.3},7).to({y:-586},20).to({x:-218.9,y:-582.6},6).wait(49));

	// 圖層 6
	this.instance_1 = new lib.元件3();
	this.instance_1.setTransform(-216.7,-583.3,1,1,0,0,0,11.6,9.1);

	this.timeline.addTween(cjs.Tween.get({}).to({state:[{t:this.instance_1}]}).wait(151));

	// 圖層 1
	this.instance_2 = new lib.ani5("synched",0);
	this.instance_2.setTransform(-309.7,-498.4);

	this.timeline.addTween(cjs.Tween.get({}).to({state:[{t:this.instance_2}]}).wait(151));

}).prototype = p = new cjs.MovieClip();
p.nominalBounds = new cjs.Rectangle(-488.8,-632.5,358.2,268.2);

})(lib = lib||{}, images = images||{}, createjs = createjs||{});
var lib, images, createjs;