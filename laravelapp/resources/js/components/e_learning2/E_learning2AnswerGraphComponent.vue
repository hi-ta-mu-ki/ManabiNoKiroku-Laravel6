<template>
  <modal name="modal_answer_graph" :draggable="true" :resizable="true" :scrollable="true" width="30%" height="auto">
    <div id="overlay">
      <div id="content">
        <div class="container-fluid">
          <PieChart :chartData="chartItems" :options="chartOptions"/>
        </div>
      </div>
    </div>
  </modal>
</template>

<script>
import PieChart from './PieChart'
export default {
  props: {
    no: 0,
    q_no: 0
  },
  components: {
   PieChart
  },
  data: function () {
    return {
      chartItems: {
        datasets: [
          {
            backgroundColor: ["#ff0000", "#ffff00", "#0000ff", "#00ff00"], // データセットの円弧の塗りつぶし色
            borderColor: "transparent", // データセットの円弧の境界線の色データセットの円弧の塗りつぶし色
            borderWidth: 1, // データセットの円弧の境界線の太さ
            // hoverBackgroundColor: "#ececec", // マウスオーバー時の円弧の塗りつぶし色
            // hoverBorderColor: "#ececec", // マウスオーバー時の境界線の色
            // hoverBorderWidth: 2, // マウスオーバー時の境界線の太さ
            data: [] // データ値
          }
        ],
        labels: ["1", "2", "3", "4"] // 凡例とツールチップに表示するラベル
      },
      chartOptions: {
        responsive: true, // コンテナサイズが変更された際に、チャートキャンバスサイズを変更します
        responsiveAnimationDuration: 0, // サイズ変更イベント後に新しいサイズにアニメーションするのに要する時間（ミリ秒）
        maintainAspectRatio: false, // サイズ変更の際に、元のキャンバスのアスペクト比(width / height)を維持します。
        // onResize(chart, size): void {
        //   // サイズ変更が発生したときに呼び出されます。チャートインスタンスと新しいサイズの2つの引数を渡します。
        // },
        layout: {
          // レイアウトに関する設定
          // See https://misc.0o0o.org/chartjs-doc-ja/configuration/layout.html
          padding: 0 // グラフの内側に追加するパディング
        },
        title: {
          // タイトル
          // See https://misc.0o0o.org/chartjs-doc-ja/configuration/title.html
          display: true, // タイトルを表示します。
          position: "top", // タイトルの位置
          fontSize: 20, // タイトルのフォントサイズ
          padding: 10, // タイトルテキストの上下に追加するピクセル数
          text: ""
        },
        legend: {
          // 凡例に関する設定
          // See https://misc.0o0o.org/chartjs-doc-ja/configuration/legend.html
          display: true, // 凡例を表示します。
          position: "bottom" // 凡例の位置
        },
        tooltips: {
          // ツールチップに関する設定
          // See https://misc.0o0o.org/chartjs-doc-ja/configuration/tooltip.html
          display: true // キャンバス上でツールチップを有効にします
        },
        elements: {
          // 要素に関する設定
          // See https://misc.0o0o.org/chartjs-doc-ja/configuration/elements.html
          point: {
            // 点に関する設定
          },
          line: {
            // 線に関する設定
          },
          rectangle: {
            // 矩形に関する設定
          },
          arc: {
            // 円弧に関する設定
          }
        },
        animation: {
          // アニメーションに関する設定
          // See https://misc.0o0o.org/chartjs-doc-ja/configuration/animations.html
          duration: 1000, // アニメーションにかける時間（ミリ秒）
          easing: "easeOutQuart", // 使用するイージング(easing)(訳注:アニメーションの効果
          // onProgress: null, // アニメーションの各ステップで呼び出されるコールバック
          // onComplete: null, // アニメーションの最後に呼び出されるコールバック
          animateRotate: true, // （円グラフ）trueの場合、グラフは回転アニメーションをします。
          animateScale: true // （円グラフ）trueの場合、中央から外側に向かってグラフが拡大するアニメーションをします。
        },
        rotation: -0.5 * Math.PI, // （円グラフ）弧を描画する開始角度
        circumference: 2 * Math.PI, // （円グラフ）弧全体の角度
        // cutoutPercentage: 50, // （ドーナツ）中央部から切り取られるグラフの割合
        // startAngle: -0.5 * Math.PI // (鶏頭図のみ) データセットの最初の項目の円弧を描画する開始角度
      plugins: {
        labels: {
          render: 'percentage',
          fontColor: 'white',
          fontSize: 20
        }
      }
      }
    }
  },
  methods: {
    getAnswersData() {
      axios.get('/api/e_learning2/question/answer_g/'+ this.$store.getters['auth_e_learning2/e_groups_id'] +'/' + this.no + '/' + this.q_no)
       .then((res) => {
          this.chartItems.datasets[0].data = res.data;
        });
    },
    clickEvent: function() {
      this.$emit('from-child')
    },
  },
  mounted() {
    this.getAnswersData();
    this.chartOptions.title.text = "問" + this.q_no;
  }
}
</script>