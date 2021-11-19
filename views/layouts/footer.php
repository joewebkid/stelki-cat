<?php

use \app\models\PageContent;
$phone = PageContent::findOne(3)->value;
?>
<footer class="footer">
    <div class="footer__content">
        <div class="footer__container">
            <div class="footer__back"></div>
            <div class="footer__contacts contacts _container">
                <div class="contacts__column contacts__socials">
                    <h3 class="footer__title title">Наши контакты</h3>
                    <div class="socials-container">
                        <div class="contacts__telegram soc_ico">
                            <a href=''>
                                <svg width="109" height="110" viewBox="0 0 109 110" fill="none" xmlns="http://www.w3.org/2000/svg" class="svg_ico">
                                    <path fill-rule="evenodd" clip-rule="evenodd" d="M12.1599 0.163778C6.21276 1.17285 1.10616 6.44889 0.178885 12.5425C0.0251928 13.5524 -0.027246 27.3243 0.0130423 55.985L0.0723024 97.9488L0.672364 99.6704C2.34742 104.475 5.54491 107.703 10.3043 109.394L12.0096 110H54.5362H97.0627L98.768 109.392C103.689 107.639 107.082 104.065 108.609 99.0248C108.983 97.7907 109 95.8412 109 54.909V12.0843L108.4 10.3627C106.725 5.55796 103.527 2.32997 98.768 0.638938L97.0627 0.0331517L55.1756 0.00259344C31.5319 -0.0146225 12.797 0.0555325 12.1599 0.163778ZM87.2878 28.7838C87.9793 29.2129 88.6427 30.3369 88.6427 31.0797C88.6427 31.6442 78.0319 79.0591 77.7348 79.8226C77.2138 81.1614 75.2493 82.125 73.8415 81.7327C73.4425 81.6215 69.4256 79.0027 64.9152 75.9131C60.4046 72.8235 56.6499 70.2957 56.5712 70.2957C56.4926 70.2957 54.6837 71.9702 52.5512 74.0165C47.6375 78.7322 47.695 78.6885 46.4039 78.6885C45.5222 78.6885 45.2526 78.582 44.6342 77.9891C43.9761 77.3581 43.6187 76.436 40.985 68.5741C39.3792 63.7806 37.9583 59.7469 37.8274 59.6104C37.6965 59.4742 33.9923 58.3771 29.5958 57.1729C22.3969 55.201 21.5438 54.9204 21.0158 54.351C20.6488 53.9548 20.4296 53.4798 20.4296 53.0798C20.4296 51.5413 19.5746 51.9003 46.8622 41.9854C60.7553 36.9373 74.3766 31.9827 77.1317 30.9752C79.8869 29.9676 82.8126 28.9133 83.6333 28.6325C85.2894 28.0659 86.1908 28.1033 87.2878 28.7838ZM58.2798 47.8123C48.7905 53.3124 40.95 57.9338 40.8567 58.0823C40.7633 58.2308 40.6855 58.602 40.6836 58.9074C40.6793 59.6528 45.2539 73.1618 45.5438 73.2595C45.8198 73.3522 45.8846 72.9741 46.441 68.0361C46.6812 65.9057 46.9236 63.9456 46.9801 63.6805C47.0479 63.3607 52.0153 59.1295 61.7341 51.1126C69.7924 44.4654 76.4575 38.9203 76.5453 38.7903C76.8361 38.3595 76.6029 37.9089 76.064 37.8605C75.6992 37.8275 70.1324 40.9428 58.2798 47.8123Z"
                                    fill="#002A57" />
                                </svg>
                            </a>
                        </div>
                        <div class="contacts__instagram soc_ico">
                            <a href=''>
                                <svg width="110" height="110" viewBox="0 0 110 110" fill="none" xmlns="http://www.w3.org/2000/svg" class="svg_ico">
                                    <path d="M50.1914 45.3275C50.9145 44.9782 51.8813 44.6044 52.3398 44.4967C53.726 44.1714 56.7484 44.2264 58.0224 44.6001C62.6132 45.9469 65.7499 50.1035 65.7895 54.8928C65.835 60.381 61.9511 64.9296 56.5039 65.7678C52.1557 66.4368 47.3875 64.0005 45.4109 60.1C42.6222 54.5967 44.7752 47.9441 50.1914 45.3275Z"
                                    fill="white" />
                                    <path fill-rule="evenodd" clip-rule="evenodd" d="M28.6911 35.7296C30.5927 31.4299 34.7095 28.3186 39.3104 27.7043C39.9635 27.6171 47.3623 27.5636 55.752 27.5853C69.5043 27.6207 71.1328 27.6611 72.2949 27.9967C76.3153 29.1569 79.5558 31.9039 81.2133 35.5566C81.4059 35.9811 81.567 36.3299 81.7019 36.6886C82.4045 38.5577 82.3926 40.6955 82.3926 55.2148C82.3926 70.1454 82.366 71.3073 81.9973 72.5098C80.6498 76.9048 77.347 80.3771 73.1543 81.8065L71.4356 82.3926H38.5645L36.7288 81.7352C35.7193 81.3736 34.3475 80.7157 33.6806 80.2729C31.1848 78.6163 29.0342 75.7131 28.0098 72.6172C27.6489 71.5266 27.6135 70.2361 27.5501 55.8632C27.4753 38.9129 27.5035 38.4149 28.6911 35.7296ZM77.1904 37.2754C77.1904 35.3678 75.9945 33.7356 74.1428 33.1156C70.7154 31.9681 67.4141 35.7008 68.9438 38.9941C69.4165 40.0121 70.0369 40.6972 70.8821 41.1342C73.7585 42.6216 77.1904 40.5221 77.1904 37.2754ZM64.3206 39.9276C62.6102 38.9207 60.4658 38.0707 58.6831 37.6928C57.1261 37.3628 53.0924 37.3194 51.5786 37.6164C44.7846 38.9495 39.3115 44.3115 37.6727 51.2402C37.2462 53.0434 37.2036 56.7078 37.5878 58.5449C38.7585 64.1435 42.512 68.8138 47.7765 71.2222C50.2576 72.357 51.9574 72.7053 55 72.7016C58.1857 72.698 59.8353 72.345 62.4959 71.0982C71.9284 66.678 75.5249 55.3495 70.403 46.1914C69.3007 44.22 66.2159 41.0435 64.3206 39.9276Z"
                                    fill="white" />
                                    <path fill-rule="evenodd" clip-rule="evenodd" d="M0 13.6646C0 6.11785 6.11785 0 13.6646 0H96.3354C103.882 0 110 6.11785 110 13.6646V96.3354C110 103.882 103.882 110 96.3354 110H13.6646C6.11785 110 0 103.882 0 96.3354V13.6646ZM83.4823 26.8866C80.8315 24.1297 77.2131 22.0786 73.3118 21.1213C72.0408 20.8093 69.9104 20.761 55.752 20.7228C46.8897 20.6989 39.3487 20.7189 38.9942 20.7672C34.2779 21.4103 30.3948 23.1997 27.222 26.1929C23.6202 29.5909 21.5347 33.5685 20.8459 38.3548C20.6716 39.5646 20.6222 44.8057 20.6777 56.1816C20.7556 72.1772 20.7597 72.3074 21.2446 74.0137C23.3409 81.389 28.8387 86.8575 36.0938 88.7829C37.9161 89.2665 37.9571 89.2676 55 89.2676C72.0429 89.2676 72.084 89.2665 73.9063 88.7829C81.1843 86.8512 86.8358 81.1903 88.7672 73.8968C89.2412 72.1069 89.2495 71.8431 89.3245 56.0742C89.4059 38.9961 89.3649 38.0924 88.3644 34.9173C87.386 31.8134 85.9532 29.4564 83.4823 26.8866Z"
                                    fill="white" />
                                </svg>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="contacts__column">
                    <div class="contacts__phone">
                        <h4 class="phone-number title"><?= $phone ?></h4>
                    </div>
                    <div class="contacts__adress">Москва, Волочаевская ул. 45</div>
                </div>
            </div>
        </div>
    </div>
</footer>