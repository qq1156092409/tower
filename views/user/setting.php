<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2015/8/7
 * Time: 21:25
 */
?>
<div class="container workspace simple-stack simple-stack-transition">
    <div class="page page-root simple-pjax">
        <div class="page-inner" id="page-member-settings" data-page-name="个人设置">
            <p class="page-tip moveout" style="display:none;"></p>

            <h3>个人设置</h3>

            <a href="javascript:;" id="btn-del-member" class="link-delete">退出团队</a>

            <form class="form settings-form" action="/members/27e71406402a4a9388776055bcd4161b/settings" method="post"
                  data-remote="true">
                <div class="form-item upload-avatar" data-droppable="">
                    <div class="avatar-wrapper">
                        <img class="avatar" src="https://avatar.tower.im/3c1e91ce593149a5a1e13306470f1c37">

                        <div class="loading"></div>
                    </div>
                    <div class="link-upload" data-url="/members/27e71406402a4a9388776055bcd4161b/avatars/"
                         style="position: relative; overflow: hidden; direction: ltr;">
                        <a id="btn-upload" href="javascript:;">选择新头像</a>
                        <input type="file" title="选择新头像" name="upload_file" tabindex="-1"
                               style="position: absolute; right: 0px; top: 0px; font-family: Arial; font-size: 118px; margin: 0px; padding: 0px; cursor: pointer; opacity: 0;">
                    </div>
                    <p class="desc">你可以选择png/jpg图片(100*100)作为头像</p>
                </div>
                <div class="form-item">
                    <div class="form-label">
                        <label for="txt-email">邮箱</label>
                    </div>
                    <div class="form-field">
                        <input type="text" name="email" id="txt-email" value="1632799080@qq.com" disabled="">
                        <a href="/members/27e71406402a4a9388776055bcd4161b/settings/email" class="modify-email"
                           data-stack="true">修改邮箱</a>
                    </div>
                </div>
                <div class="form-item">
                    <div class="form-label">
                        <label for="txt-nickname">名字</label>
                    </div>
                    <div class="form-field">
                        <input type="text" name="nickname" id="txt-nickname" autocomplete="off" value="方片周"
                               data-validate="required;length:1,30" data-validate-msg="好像还没有输入名字呢;名字最长30个字符">
                    </div>
                </div>
                <div class="form-item">
                    <div class="form-label">
                        <label>密码</label>
                    </div>
                    <div class="form-field form-text-field">
                        <a href="/members/27e71406402a4a9388776055bcd4161b/settings/password" data-stack="true">修改密码</a>
                    </div>
                </div>
                <div class="form-item form-item-wechat">
                    <div class="form-label">
                        <label>绑定微信</label>
                    </div>
                    <div class="form-field form-text-field">
                        <span class="status">未绑定</span>
                        <a href="javascript:;" class="link-bind-wechat">绑定</a>

                        <p class="desc">绑定后，可直接使用微信登录 Tower 「桌面版」和「移动版」</p>
                    </div>
                </div>


                <div class="form-item">
                    <div class="form-label">
                        <label for="link-notify-settings">通知设置</label>
                    </div>
                    <div class="form-field form-text-field notification-field">
                        <a href="/members/27e71406402a4a9388776055bcd4161b/notification_settings"
                           class="link-notify-settings" data-stack="true">修改通知设置</a>

                        <p class="desc">
                            桌面通知：关闭<br>
                            邮件通知：关闭<br>
                            智能提醒：网页在线时，不发送邮件通知和客户端推送<br>
                            延期任务通知邮件：开启
                        </p>
                    </div>
                </div>

                <div class="form-item">
                    <div class="form-label">
                        <label for="link-time-zone-settings">时区设置</label>
                    </div>
                    <div class="form-field form-text-field time-zone-field">
                        <p>
                            <select id="user_time_zone" name="user[time_zone]">
                                <option value="Hawaii">(GMT-10:00) 夏威夷</option>
                                <option value="Alaska">(GMT-09:00) 阿拉斯加</option>
                                <option value="Pacific Time (US &amp; Canada)">(GMT-08:00) 太平洋时区(美国与加拿大)</option>
                                <option value="Arizona">(GMT-07:00) 亚利桑那州</option>
                                <option value="Mountain Time (US &amp; Canada)">(GMT-07:00) 山区时区(美国与加拿大)</option>
                                <option value="Central Time (US &amp; Canada)">(GMT-06:00) 中部时区(美国与加拿大)</option>
                                <option value="Eastern Time (US &amp; Canada)">(GMT-05:00) 东部时区(美国与加拿大)</option>
                                <option value="Indiana (East)">(GMT-05:00) 印第安那州(东部)</option>
                                <option value="" disabled="disabled">-------------</option>
                                <option value="American Samoa">(GMT-11:00) 美属萨摩亚群岛</option>
                                <option value="International Date Line West">(GMT-11:00) 国际换日线(西)</option>
                                <option value="Midway Island">(GMT-11:00) 中途岛</option>
                                <option value="Tijuana">(GMT-08:00) 提华纳</option>
                                <option value="Chihuahua">(GMT-07:00) 契瓦瓦</option>
                                <option value="Mazatlan">(GMT-07:00) 马萨特兰</option>
                                <option value="Central America">(GMT-06:00) 中美洲</option>
                                <option value="Guadalajara">(GMT-06:00) 瓜达拉哈拉</option>
                                <option value="Mexico City">(GMT-06:00) 墨西哥市</option>
                                <option value="Monterrey">(GMT-06:00) 蒙特雷</option>
                                <option value="Saskatchewan">(GMT-06:00) 萨斯喀彻温</option>
                                <option value="Bogota">(GMT-05:00) 波哥大</option>
                                <option value="Lima">(GMT-05:00) 利马</option>
                                <option value="Quito">(GMT-05:00) 基多</option>
                                <option value="Caracas">(GMT-04:30) 卡拉卡斯</option>
                                <option value="Atlantic Time (Canada)">(GMT-04:00) 大西洋时间(加拿大)</option>
                                <option value="Georgetown">(GMT-04:00) 乔治城</option>
                                <option value="La Paz">(GMT-04:00) 拉巴斯</option>
                                <option value="Newfoundland">(GMT-03:30) 纽芬兰</option>
                                <option value="Brasilia">(GMT-03:00) 巴西利亚</option>
                                <option value="Buenos Aires">(GMT-03:00) 布宜诺斯艾利斯</option>
                                <option value="Greenland">(GMT-03:00) 格陵兰</option>
                                <option value="Santiago">(GMT-03:00) 圣地亚哥</option>
                                <option value="Mid-Atlantic">(GMT-02:00) 大西洋中部</option>
                                <option value="Azores">(GMT-01:00) 亚速群岛</option>
                                <option value="Cape Verde Is.">(GMT-01:00) 维德角岛</option>
                                <option value="Casablanca">(GMT+00:00) 达尔贝达</option>
                                <option value="Dublin">(GMT+00:00) 都布林</option>
                                <option value="Edinburgh">(GMT+00:00) 爱丁堡</option>
                                <option value="Lisbon">(GMT+00:00) 里斯本</option>
                                <option value="London">(GMT+00:00) 伦敦</option>
                                <option value="Monrovia">(GMT+00:00) 蒙罗维亚</option>
                                <option value="UTC">(GMT+00:00) 世界标準时间</option>
                                <option value="Amsterdam">(GMT+01:00) 阿姆斯特丹</option>
                                <option value="Belgrade">(GMT+01:00) 贝尔格勒</option>
                                <option value="Berlin">(GMT+01:00) 柏林</option>
                                <option value="Bern">(GMT+01:00) 伯恩</option>
                                <option value="Bratislava">(GMT+01:00) 布拉提斯拉瓦</option>
                                <option value="Brussels">(GMT+01:00) 布鲁塞尔</option>
                                <option value="Budapest">(GMT+01:00) 布达佩斯</option>
                                <option value="Copenhagen">(GMT+01:00) 哥本哈根</option>
                                <option value="Ljubljana">(GMT+01:00) 卢比安纳</option>
                                <option value="Madrid">(GMT+01:00) 马德里</option>
                                <option value="Paris">(GMT+01:00) 巴黎</option>
                                <option value="Prague">(GMT+01:00) 布拉格</option>
                                <option value="Rome">(GMT+01:00) 罗马</option>
                                <option value="Sarajevo">(GMT+01:00) 塞拉耶佛</option>
                                <option value="Skopje">(GMT+01:00) 史高比耶</option>
                                <option value="Stockholm">(GMT+01:00) 斯德哥尔摩</option>
                                <option value="Vienna">(GMT+01:00) 维也纳</option>
                                <option value="Warsaw">(GMT+01:00) 华沙</option>
                                <option value="West Central Africa">(GMT+01:00) 中西非时区</option>
                                <option value="Zagreb">(GMT+01:00) 札格瑞布</option>
                                <option value="Athens">(GMT+02:00) 雅典</option>
                                <option value="Bucharest">(GMT+02:00) 布加勒斯特</option>
                                <option value="Cairo">(GMT+02:00) 开罗</option>
                                <option value="Harare">(GMT+02:00) 哈拉雷</option>
                                <option value="Helsinki">(GMT+02:00) 赫尔辛基</option>
                                <option value="Istanbul">(GMT+02:00) 伊斯坦堡</option>
                                <option value="Jerusalem">(GMT+02:00) 耶路撒冷</option>
                                <option value="Kyiv">(GMT+02:00) 基辅</option>
                                <option value="Pretoria">(GMT+02:00) 普勒托利亚</option>
                                <option value="Riga">(GMT+02:00) 里加</option>
                                <option value="Sofia">(GMT+02:00) 索菲亚</option>
                                <option value="Tallinn">(GMT+02:00) 塔林</option>
                                <option value="Vilnius">(GMT+02:00) 维尔纽斯</option>
                                <option value="Baghdad">(GMT+03:00) 巴格达</option>
                                <option value="Kuwait">(GMT+03:00) 科威特</option>
                                <option value="Minsk">(GMT+03:00) 明斯克</option>
                                <option value="Moscow">(GMT+03:00) 莫斯科</option>
                                <option value="Nairobi">(GMT+03:00) 奈洛比</option>
                                <option value="Riyadh">(GMT+03:00) 利雅德</option>
                                <option value="St. Petersburg">(GMT+03:00) 圣彼得堡</option>
                                <option value="Volgograd">(GMT+03:00) 伏尔加格勒</option>
                                <option value="Tehran">(GMT+03:30) 德黑兰</option>
                                <option value="Abu Dhabi">(GMT+04:00) 阿布达比</option>
                                <option value="Baku">(GMT+04:00) 巴库</option>
                                <option value="Muscat">(GMT+04:00) 马斯喀特</option>
                                <option value="Tbilisi">(GMT+04:00) 提比里斯</option>
                                <option value="Yerevan">(GMT+04:00) 叶里温</option>
                                <option value="Kabul">(GMT+04:30) 喀布尔</option>
                                <option value="Ekaterinburg">(GMT+05:00) 叶卡捷琳堡</option>
                                <option value="Islamabad">(GMT+05:00) 伊斯兰玛巴德</option>
                                <option value="Karachi">(GMT+05:00) 喀拉蚩</option>
                                <option value="Tashkent">(GMT+05:00) 塔什干</option>
                                <option value="Chennai">(GMT+05:30) 清奈</option>
                                <option value="Kolkata">(GMT+05:30) 加尔各答</option>
                                <option value="Mumbai">(GMT+05:30) 孟买</option>
                                <option value="New Delhi">(GMT+05:30) 新德里</option>
                                <option value="Sri Jayawardenepura">(GMT+05:30) 科泰</option>
                                <option value="Kathmandu">(GMT+05:45) 加德满都</option>
                                <option value="Almaty">(GMT+06:00) 阿拉木图</option>
                                <option value="Astana">(GMT+06:00) 阿斯塔纳</option>
                                <option value="Dhaka">(GMT+06:00) 达卡</option>
                                <option value="Novosibirsk">(GMT+06:00) 新西伯利亚</option>
                                <option value="Urumqi">(GMT+06:00) 乌鲁木齐</option>
                                <option value="Rangoon">(GMT+06:30) 仰光</option>
                                <option value="Bangkok">(GMT+07:00) 曼谷</option>
                                <option value="Hanoi">(GMT+07:00) 河内</option>
                                <option value="Jakarta">(GMT+07:00) 雅加达</option>
                                <option value="Krasnoyarsk">(GMT+07:00) 克拉斯诺亚尔斯克</option>
                                <option value="Beijing" selected="selected">(GMT+08:00) 北京</option>
                                <option value="Chongqing">(GMT+08:00) 重庆</option>
                                <option value="Hong Kong">(GMT+08:00) 香港</option>
                                <option value="Irkutsk">(GMT+08:00) 伊尔库茨克</option>
                                <option value="Kuala Lumpur">(GMT+08:00) 吉隆坡</option>
                                <option value="Perth">(GMT+08:00) 珀斯</option>
                                <option value="Singapore">(GMT+08:00) 新加坡</option>
                                <option value="Taipei">(GMT+08:00) 台北</option>
                                <option value="Ulaan Bataar">(GMT+08:00) 乌兰巴托</option>
                                <option value="Osaka">(GMT+09:00) 大阪</option>
                                <option value="Sapporo">(GMT+09:00) 札幌</option>
                                <option value="Seoul">(GMT+09:00) 首尔</option>
                                <option value="Tokyo">(GMT+09:00) 东京</option>
                                <option value="Yakutsk">(GMT+09:00) 雅库茨克</option>
                                <option value="Adelaide">(GMT+09:30) 阿得雷德</option>
                                <option value="Darwin">(GMT+09:30) 达尔文</option>
                                <option value="Brisbane">(GMT+10:00) 布里斯本</option>
                                <option value="Canberra">(GMT+10:00) 坎培拉</option>
                                <option value="Guam">(GMT+10:00) 关岛</option>
                                <option value="Hobart">(GMT+10:00) 荷巴特</option>
                                <option value="Magadan">(GMT+10:00) 马加丹</option>
                                <option value="Melbourne">(GMT+10:00) 墨尔本</option>
                                <option value="Port Moresby">(GMT+10:00) 莫士比港</option>
                                <option value="Solomon Is.">(GMT+10:00) 索罗门群岛</option>
                                <option value="Sydney">(GMT+10:00) 雪梨</option>
                                <option value="Vladivostok">(GMT+10:00) 海参崴</option>
                                <option value="New Caledonia">(GMT+11:00) 新喀里多尼亚</option>
                                <option value="Auckland">(GMT+12:00) 奥克兰</option>
                                <option value="Fiji">(GMT+12:00) 斐济</option>
                                <option value="Kamchatka">(GMT+12:00) 堪察加</option>
                                <option value="Marshall Is.">(GMT+12:00) 马绍尔群岛</option>
                                <option value="Wellington">(GMT+12:00) 威灵顿</option>
                                <option value="Nuku'alofa">(GMT+13:00) 努瓜娄发</option>
                                <option value="Samoa">(GMT+13:00) 萨摩亚</option>
                                <option value="Tokelau Is.">(GMT+13:00) 托克劳群岛</option>
                            </select>
                        </p>
                    </div>
                </div>

                <div class="form-buttons">
                    <button class="btn" id="btn-save" data-disable-with="正在保存..." data-success-text="保存成功">保存</button>
                </div>
            </form>

            <script type="text/html" id="tpl-unbind-wechat">
                <div class="unbind-wechat-confirm">
                    <p>确定要解除微信绑定吗？解除后，你将会：</p>
                    <ul>
                        <li>不能用微信扫码登录「桌面版」和「移动版」</li>
                        <li>不能使用 Tower 微信版</li>
                    </ul>
                </div>
            </script>

            <script type="text/html" id="tpl-del-owner">
                <div class="del-owner-message">
                    <p>身为团队领袖，岂能说退就退。</p>

                    <p>请将<a href="/teams/3204fcfe7d0344b6bb4575cb6c04729c/settings" data-stack
                            data-stack-root>团队移交他人</a>之后再行退出。
                </div>
            </script>

            <script type="text/html" id="tpl-del-member">
                <form class="form form-del-member-confirm" action="/members/27e71406402a4a9388776055bcd4161b/kick_out"
                      method="post" data-remote novalidate>
                    <h4 class="simple-dialog-title">退出团队</h4>

                    <p>你将会退出 iphone7。</p>

                    <p>如果你确定要这样做，请在下面输入登录密码确认。</p>

                    <p>
                        <input type="password" id="del-member-password" name="password" autocomplete="off"
                               data-validate="length:6;custom" data-validate-msg="密码输入错误"/>
                    </p>

                    <div class="form-buttons">
                        <button type="submit" class="btn btn-primary">确认退出</button>
                        <button type="button" class="btn btn-x btn-cancel">取消</button>
                    </div>
                </form>
            </script>

            <script type="text/html" id="tpl-bind-wechat">
                <div class="qrcode-sheet">
                    <div class="qrcode-wrap loading">
                        <p class="indicator">正在加载二维码</p>
                        <img class="qrcode" alt="微信扫码，完成账户绑定" title="微信扫码，完成账户绑定"/>
                    </div>
                    <p>微信扫码，完成账户绑定</p>
                </div>

                <div class="success-sheet">
                    <div class="success-info">
                        <h3 class="single-line">绑定成功</h3>
                    </div>
                    <p class="exit">
                        现在你可以「<a href="/users/sign_out" data-method="delete" rel="nofollow">退出重新登录</a>」<br>
                        体验扫码登录的快感！
                    </p>

                    <p class="desc">
                        你已成功关注 Tower 微信服务号<br>
                        为了更好的服务，请勿随意取关 : )
                    </p>
                </div>
            </script>

            <script type="text/html" id="tpl-two-factor-auth">
                <div class="message-sheet">
                </div>
            </script>

            <input type="hidden" value="false" id="tpl-two-factor-auth-has-messages">
        </div>
    </div>
</div>
