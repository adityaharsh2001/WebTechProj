let editor;
let editor2;
window.onload = function() {
    editor = ace.edit("editor");
    editor.setTheme("ace/theme/monokai");
    editor.session.setMode("ace/mode/c_cpp");
    editor2 = ace.edit("editor2");
    editor2.setTheme("ace/theme/monokai");
    editor2.session.setMode("ace/mode/c_cpp");


}

function changeLanguage() {

    let language = $("#select-lang").val();

    if(language == 'c' || language == 'c_cpp')editor.session.setMode("ace/mode/c_cpp");
    else if(language == 'php')editor.session.setMode("ace/mode/php");
    else if(language == 'python')editor.session.setMode("ace/mode/python");
    else if(language == 'node')editor.session.setMode("ace/mode/javascript");
}

function executeCode() {

    $.ajax({

        url: "/app/compiler.php",

        method: "POST",

        data: {
            language: $("#select-lang").val(),
            code: editor.getSession().getValue()
        },

        success: function(response) {
            console.log(response);
            $(".output").text(response)
        }
    })
}