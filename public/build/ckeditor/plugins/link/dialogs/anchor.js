CKEDITOR.dialog.add("anchor",(function(e){function t(e,t){return e.createFakeElement(e.document.createElement("a",{attributes:t}),"cke_anchor","anchor")}return{title:e.lang.link.anchor.title,minWidth:300,minHeight:60,getModel:function(e){var t=e.getSelection();return e=t.getRanges()[0],t=t.getSelectedElement(),e.shrink(CKEDITOR.SHRINK_ELEMENT),(t=e.getEnclosedNode())&&t.type===CKEDITOR.NODE_TEXT&&(t=t.getParent()),t&&!t.is("a")&&(t=t.getAscendant("a")||t),(e=t&&t.type===CKEDITOR.NODE_ELEMENT&&("anchor"===t.data("cke-real-element-type")||t.is("a"))?t:void 0)||null},onOk:function(){var n={id:n=CKEDITOR.tools.trim(this.getValueOf("info","txtName")),name:n,"data-cke-saved-name":n},a=this.getModel(e);if(a)a.data("cke-realelement")?((n=t(e,n)).replace(a),CKEDITOR.env.ie&&e.getSelection().selectElement(n)):a.setAttributes(n);else if((a=(a=e.getSelection())&&a.getRanges()[0]).collapsed)n=t(e,n),a.insertNode(n);else{CKEDITOR.env.ie&&9>CKEDITOR.env.version&&(n.class="cke_anchor"),(i=a.clone()).enlarge(CKEDITOR.ENLARGE_ELEMENT);for(var l=new CKEDITOR.dom.walker(i),i=i.collapsed?i.startContainer:l.next(),o=a.createBookmark();i;)i.type===CKEDITOR.NODE_ELEMENT&&i.getAttribute("data-cke-saved-name")&&(i.remove(!0),l.reset()),i=l.next();a.moveToBookmark(o),(n=new CKEDITOR.style({element:"a",attributes:n})).type=CKEDITOR.STYLE_INLINE,n.applyToRange(a)}},onShow:function(){var t=e.getSelection(),n=this.getModel(e),a=n&&n.data("cke-realelement");if(n=a?CKEDITOR.plugins.link.tryRestoreFakeAnchor(e,n):CKEDITOR.plugins.link.getSelectedLink(e)){var l=n.data("cke-saved-name");this.setValueOf("info","txtName",l||""),!a&&t.selectElement(n)}this.getContentElement("info","txtName").focus()},contents:[{id:"info",label:e.lang.link.anchor.title,accessKey:"I",elements:[{type:"text",id:"txtName",label:e.lang.link.anchor.name,required:!0,validate:function(){return!!this.getValue()||(alert(e.lang.link.anchor.errorName),!1)}}]}]}}));