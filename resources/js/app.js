// require('./bootstrap');
// import './micromodal';
// import '../css/micromodal.css';

// import './swiper'; 

// require('alpinejs');


require('./bootstrap');

// MicroModal のインポート
import MicroModal from 'micromodal';

// Swiper のインポート
import './swiper';

// Alpine.js の読み込み
require('alpinejs');

// MicroModal の初期化
MicroModal.init({
    disableScroll: true
});

// CSSファイルのインポート（Webpackの設定によっては不要な場合があります）
// import '../css/micromodal.css';