var Base = function() {

};

Base.prototype = {
    alert : function() {
        alert(111);
    },

    url : null,
    params : {},
    method : 'post',

    setUrl : function(url) {
        this.url = url;
        return this;
    },

    getUrl : function() {
        return this.url;
    },

    setMethod : function(method) {
        this.method = method;
        return this;
    },

    getMethod : function() {
        return this.method;
    },

    resetParams : function() {
        this.params = {};
        return this;
    },

    setParams : function(params) {
        this.params = params;
        return this;
    },

    getParams : function(key) {
        if (typeof key === 'undefined') {
            return this.params;
        }
        if(typeof this.params[key] === 'undefined') {
            return null;
        }
        return this.params[key];
    },

    addParam : function(key, value) {
        this.params[key] = value;
        return this;
    },

    removeParam : function(key) {
        if(typeof this.params[key] != 'undefined') {
            delete this.params[key];
        }
        return this;
    },

    load : function() {

        var request = $.ajax({
            method : this.getMethod(),
            url : this.getUrl(),
            data : this.getParams(),

            // success : function(response){
			// 	$.each(response.element, function (i, element) {
			// 		$(element.selector).html(element.html);
			// 	});
			// }
            success : function(response) {
                console.log(response);
                if(typeof response.element == 'object') {
                    $(response.element).each(function(i, element){
                        $(element.selector).html(element.html);
                    });
                }
                else {
                    $(response.element.selector).html(response.element.html);
                }
            }
        });

        // request.done(function(response) {
        //     $(response.element.selector).html(response.element.html);
        //     console.log(response.element.selector);
        // });
    }

}

var object = new Base();
object.setParams({
    name : 'rohit',
    email : 'lalwanirohit111@gmail.com'
});
object.setUrl('http://localhost/projects/cybercom/index.php?controller=product&action=showHtml');
object.load();