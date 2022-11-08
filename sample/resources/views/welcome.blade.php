<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="utf-8" />
    <title>サンプル</title>
    <link rel="stylesheet" href="{{ asset('/js/jquery-ui-1.13.1/jquery-ui.css') }}" />
    <script src="{{ asset('/js/jquery-ui-1.13.1/external/jquery/jquery.js') }}"></script>
    <script src="{{ asset('/js/jquery-ui-1.13.1/jquery-ui.js') }}"></script>
</head>

<body>
    <section id="parent" data-dialog-result="{{json_encode(['a' => 1, 'b'=> 'x'])}}"> <!-- ←ここはサーバー側で設定 -->
        <div id="sample-display-a">xxx</div>
        <div id="sample-display-b">yyy</div>
        <button id="btn-dialog">子画面</button>
    </section>
    <div id="sample-dialog" style="display:none;">
        <div>
            <input type="text" id="sample-text-a" />
        </div>
        <div>
            <input type="text" id="sample-text-b" />
        </div>
    </div>
    <script>
        (function($) {
            $("#btn-dialog").click(function() {
                // データ保持用要素のdata要素からデータを取り出す。
                // ※JSON.parseしなくてもobjectで取り出される。
                var data = $("#parent").data('dialogResult');
                // 子画面のinput要素にセット
                $("#sample-text-a").val(data.a);
                $("#sample-text-b").val(data.b);

                $("#sample-dialog").dialog({
                    modal: true,
                    title: "選択肢",
                    buttons: [{
                            text: "保存",
                            click: function() {
                                // 子画面の入力値を…
                                var a = $("#sample-text-a").val(),
                                    b = $("#sample-text-b").val(),
                                    data = {
                                        a: a,
                                        b: b,
                                    };

                                // ☆objectを親画面のしかるべき要素のdata属性にセットする。☆
                                $("#parent").data('dialogResult', data);

                                // 子画面を閉じる
                                $(this).dialog("close");
                            }
                        },
                        {
                            text: "閉じる",
                            click: function() {
                                $(this).dialog("close");
                            }
                        }
                    ],
                    close: function() {
                        // destroy しないと画面バグる！
                        $(this).dialog("destroy");

                        // 画面閉じた後の共通処理はここに書く
                        initParent();
                    }
                })
            });

            var initParent = function() {
                var data = $("#parent").data('dialogResult');
                $("#sample-display-a").text(data.a);
                $("#sample-display-b").text(data.b);
            }

            initParent();
        }(jQuery));
    </script>
</body>

</html>