(window["webpackJsonp"]=window["webpackJsonp"]||[]).push([["chunk-a7590e8a","chunk-2d0e62f4"],{9854:function(e,r,s){"use strict";s.r(r);var t=function(){var e=this,r=e.$createElement,s=e._self._c||r;return s("div",{staticClass:"col-6"},[s("div",{staticClass:"row row-reverse"},[s("div",{staticClass:"col-4"},[s("div",{staticClass:"form-group with-icon-right",class:{"has-error":e.errors.has("name")}},[s("div",{staticClass:"input-group"},[s("input",{directives:[{name:"model",rawName:"v-model",value:e.reference.name,expression:"reference.name"}],attrs:{id:"name",name:"name"},domProps:{value:e.reference.name},on:{input:function(r){r.target.composing||e.$set(e.reference,"name",r.target.value)}}}),s("i",{directives:[{name:"show",rawName:"v-show",value:e.errors.has("name"),expression:"errors.has('name')"}],staticClass:"fa fa-exclamation-triangle icon-right input-icon"}),s("label",{staticClass:"control-label",attrs:{for:"slug"}},[e._v(e._s(e._f("translate")("reference.name")))]),s("i",{staticClass:"bar"}),s("small",{directives:[{name:"show",rawName:"v-show",value:e.errors.has("name"),expression:"errors.has('name')"}],staticClass:"help text-danger"},[e._v(e._s(e.errors.first("name"))+"\n\t          ")])])])]),s("div",{staticClass:"col-5"},[s("div",{staticClass:"form-group with-icon-right",class:{"has-error":e.errors.has("url")}},[s("div",{staticClass:"input-group"},[s("input",{directives:[{name:"model",rawName:"v-model",value:e.reference.url,expression:"reference.url"}],attrs:{id:"url",name:"url"},domProps:{value:e.reference.url},on:{input:function(r){r.target.composing||e.$set(e.reference,"url",r.target.value)}}}),s("i",{directives:[{name:"show",rawName:"v-show",value:e.errors.has("url"),expression:"errors.has('url')"}],staticClass:"fa fa-exclamation-triangle icon-right input-icon"}),s("label",{staticClass:"control-label",attrs:{for:"url"}},[e._v(e._s(e._f("translate")("reference.url")))]),s("i",{staticClass:"bar"}),s("small",{directives:[{name:"show",rawName:"v-show",value:e.errors.has("url"),expression:"errors.has('url')"}],staticClass:"help text-danger"},[e._v(e._s(e.errors.first("url"))+"\n\t          ")])])])]),s("div",{staticClass:"col-3 text-right"},[s("div",{staticClass:"btn btn-primary btn-with-icon btn-micro rounded-icon",on:{click:e.del}},[e._m(0)])])])])},a=[function(){var e=this,r=e.$createElement,s=e._self._c||r;return s("div",{staticClass:"btn-with-icon-content"},[s("i",{staticClass:"ion-md-close ion"})])}],n={name:"reference",props:{reference:{type:Object,required:!0}},methods:{del:function(){this.$emit("del",this.reference)}}},i=n,l=s("2877"),o=Object(l["a"])(i,t,a,!1,null,null,null);o.options.__file="reference.vue";r["default"]=o.exports},"9e04":function(e,r,s){"use strict";s.r(r);var t=function(){var e=this,r=e.$createElement,s=e._self._c||r;return s("div",{staticClass:"row row-reverse"},[s("div",{staticClass:"col-12 mb-3 mt-3 text-center"},[s("div",{staticClass:"btn btn-primary btn-with-icon btn-micro",on:{click:e.add}},[e._v("\n        "+e._s(e.$t("reference.add"))+"\n      ")])]),e._l(e.references,function(r,t){return s("reference",{key:t+3,attrs:{reference:r},on:{del:e.del}})})],2)},a=[],n=s("9854"),i={name:"references",props:{references:{type:Array,required:!0}},components:{Reference:n["default"]},methods:{add:function(){var e={name:"",url:""};this.references.push(e)},del:function(e){this.$emit("delRef",e)}}},l=i,o=s("2877"),c=Object(o["a"])(l,t,a,!1,null,null,null);c.options.__file="references.vue";r["default"]=c.exports}}]);
//# sourceMappingURL=chunk-a7590e8a.5bb17dc5.js.map