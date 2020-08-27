<!--<link rel="stylesheet" href="color-spectrum/spectrum.css">-->
<link rel="stylesheet" href="/public/wxapp/enterprise/service/index.css">
<link rel="stylesheet" href="/public/wxapp/enterprise/service/style.css">
<style>
.style_1 .news-item { padding: 10px 10px; background-color: #fff; margin-top: 8px; }
.style_1 .news-item .title { font-size: 16px; line-height: 1.6; display: block; margin-bottom: 2px; font-weight: bold; overflow: hidden; white-space: nowrap; text-overflow: ellipsis; }
.style_1 .news-item img { width: 100%; height: 167px; display: block; margin-bottom: 7px; }
.style_1 .news-item .intro { font-size: 14px; color: #999; display: block; display: -webkit-box !important; overflow: hidden; text-overflow: ellipsis; word-break: break-all; -webkit-box-orient: vertical; -webkit-line-clamp: 2; }
.style_1 .news-item.border-b:after { height: 0; }

/* 列表样式2 */
.news-list.style_2 { padding-top: 8px; }
.style_2 .news-item { padding: 0; background-color: #fff; overflow: hidden; }
.style_2 .news-item img { width: 50%; height: 89px; }
.style_2 .news-item .news-intro { width: 50%; height:89px; box-sizing: border-box; padding: 7px 10px; }
.style_2 .news-item:nth-of-type(2n+1) img { float: left; }
.style_2 .news-item:nth-of-type(2n+1) .news-intro { float: right; }
.style_2 .news-item:nth-of-type(2n) img { float: right; }
.style_2 .news-item:nth-of-type(2n) .news-intro { float: left; }
.style_2 .news-item .news-intro .title { font-size: 16px; overflow: hidden; white-space: nowrap; text-overflow: ellipsis; text-align: center; margin-bottom: 2px; line-height: 1.6; font-weight: bold; }
.style_2 .news-item .news-intro .intro { font-size: 14px; color: #999; display: -webkit-box !important; overflow: hidden; text-overflow: ellipsis; word-break: break-all; -webkit-box-orient: vertical; -webkit-line-clamp: 3; }
.style_2 .news-item.border-b:after { height: 0; }

/* 列表样式3 */
.news-list.style_3 { padding-top: 8px; }
.style_3 .news-item { padding: 8px 10px; background-color: #fff; overflow: hidden; }
.style_3 .news-item img { width: 25%; height: 50px; float: left; }
.style_3 .news-item .news-intro { width: 75%; height: 50px; box-sizing: border-box; padding: 3px 10px; float: left; }
.style_3 .news-item .news-intro .title { font-size: 15px; overflow: hidden; white-space: nowrap; text-overflow: ellipsis; text-align: left; line-height: 1.6; font-weight: bold; }
.style_3 .news-item .news-intro .intro { font-size: 14px; color: #999; display: -webkit-box !important; overflow: hidden; text-overflow: ellipsis; word-break: break-all; -webkit-box-orient: vertical; -webkit-line-clamp: 1; }

/* 列表样式4 */
.news-list.style_4 { padding-top: 8px; }
.style_4 .news-item { padding: 8px 10px; background-color: #fff; overflow: hidden; }
.style_4 .news-item img { width: 25%; height: 50px; float: right; }
.style_4 .news-item .news-intro { width: 75%; height: 50px; box-sizing: border-box; padding: 3px 10px; float: left; }
.style_4 .news-item .news-intro .title { font-size: 15px; overflow: hidden; white-space: nowrap; text-overflow: ellipsis; text-align: left; line-height: 1.6; font-weight: bold; }
.style_4 .news-item .news-intro .intro { font-size: 14px; color: #999; display: -webkit-box !important; overflow: hidden; text-overflow: ellipsis; word-break: break-all; -webkit-box-orient: vertical; -webkit-line-clamp: 1; }
.radio-box span img{width: 50px;margin-left: 22px;}
.style_5 .putong,.style_1 .xinxiliu,.style_2 .xinxiliu,.style_3 .xinxiliu,.style_4 .xinxiliu{display: none;}
.style_5 .xinxiliu,.style_1 .putong,.style_2 .putong,.style_3 .putong,.style_4 .putong{display: block;}
/*信息流样式*/
.news-item .single-img,.news-item .three-img,.news-item .video-box{padding:10px;background-color: #fff;overflow: hidden;}
.news-item .single-img img{ width: 25%;height: 56px;float: right; }
.news-item .single-img .news-intro{width: 72%;float: left;height: 56px;}
.news-item .three-img img{ width: 25%;height: 56px;float: right; }
.news-item .three-img .img-box{width: 100%;overflow: hidden;text-align: center;font-size: 0;}
.news-item .three-img .img-box img{width: 28%;margin:0 2%;height: 60px;}
.news-item .video-box .img-box{width: 100%;position: relative;}
.news-item .video-box .img-box img{width:100%;height: 180px;display: block;}
.news-item .video-box .play-btn{position: absolute;width: 44px;height: 44px;left: 50%;top:50%;margin-top: -22px;margin-left: -22px;border-radius: 50%;background-color: rgba(0,0,0,.4);box-sizing: border-box;padding: 7px 0 0 4px;}
.news-item .video-box .play-btn img{width: 30px;height: 30px;display: block;margin: auto;}
</style>
<div class="preview-page" ng-app="chApp" ng-controller="chCtrl">
    <div class="mobile-page">
        <div class="mobile-header"></div>
        <div class="mobile-con">
            <div class="title-bar cur-edit" style="border-bottom: 1px solid #eee;">
                产品与服务
            </div>
            <!-- 主体内容部分 -->
            <div class="index-con">
                <!-- 首页主题内容 -->
                <div class="index-main" style="background-color: #f6f7f8;">
                    <div class="news-list style_{{listStyle}}">
                        <div class="putong">
                            <div class="news-item border-b">
                              <img src="/public/manage/img/zhanwei/zw_fxb_750_422.png" />
                              <div class="news-intro">
                                <div class="title">文章标题</div>
                                <div class="intro">文章相关简介</div>
                              </div>
                            </div>
                            <div class="news-item border-b">
                              <img src="/public/manage/img/zhanwei/zw_fxb_750_422.png" />
                              <div class="news-intro">
                                <div class="title">文章标题</div>
                                <div class="intro">文章相关简介</div>
                              </div>
                            </div>
                            <div class="news-item border-b">
                              <img src="/public/manage/img/zhanwei/zw_fxb_750_422.png" />
                              <div class="news-intro">
                                <div class="title">文章标题</div>
                                <div class="intro">文章相关简介</div>
                              </div>
                            </div>
                            <div class="news-item border-b">
                              <img src="/public/manage/img/zhanwei/zw_fxb_750_422.png" />
                              <div class="news-intro">
                                <div class="title">文章标题</div>
                                <div class="intro">文章相关简介</div>
                              </div>
                            </div>
                        </div>
                        <div class="xinxiliu">
                            <div class="news-item border-b">
                            <div class="single-img">
                                <img src="/public/manage/img/zhanwei/zw_fxb_750_422.png" />
                                <div class="news-intro">
                                    <div class="title">文章标题内容</div>
                                    
                                </div>
                            </div>
                        </div>
                        <div class="news-item border-b">
                            <div class="three-img">        
                                <div class="title">文章标题内容</div>
                                    <div class="img-box">
                                        <img src="/public/manage/img/zhanwei/zw_fxb_750_422.png" />
                                        <img src="/public/manage/img/zhanwei/zw_fxb_750_422.png" />
                                        <img src="/public/manage/img/zhanwei/zw_fxb_750_422.png" />
                                    </div>
                                </div>
                            </div>
                            <div class="news-item border-b">
                                <div class="video-box">        
                                    <div class="title">文章标题内容</div>
                                    <div class="img-box">
                                        <div class="play-btn"><img src="/public/wxapp/images/icon_bf.png" alt="图标"></div>
                                        <img src="/public/manage/img/zhanwei/zw_fxb_750_422.png" />
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- <div class="goods-show">
                        <div class="goods-view{{listStyle}}">
                            <ul>
                                <li>
                                    <a href="javascript:;">
                                        <img src="/public/manage/img/zhanwei/fenleinav.png" alt="商品">
                                        <div class="intro">
                                            <h4>此处显示资讯名称</h4>
                                            <p>此处显示资讯简介</p>
                                        </div>
                                    </a>
                                </li>
                                <li>
                                    <a href="javascript:;">
                                        <img src="/public/manage/img/zhanwei/fenleinav.png" alt="商品">
                                        <div class="intro">
                                            <h4>此处显示产品或服务名称</h4>
                                            <p>此处显示资讯简介</p>
                                        </div>
                                    </a>
                                </li>
                                <li>
                                    <a href="javascript:;">
                                        <img src="/public/manage/img/zhanwei/fenleinav.png" alt="商品">
                                        <div class="intro">
                                            <h4>此处显示产品或服务名称</h4>
                                            <p>此处显示资讯简介</p>
                                        </div>
                                    </a>
                                </li>
                                <li>
                                    <a href="javascript:;">
                                        <img src="/public/manage/img/zhanwei/fenleinav.png" alt="商品">
                                        <div class="intro">
                                            <h4>此处显示产品或服务名称</h4>
                                            <p>此处显示资讯简介</p>
                                        </div>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div> -->
                </div>
            </div>
        </div>
        <div class="mobile-footer"><span></span></div>
    </div>
    <div class="edit-right">
        <div class="edit-con">
            <div class="service-style">
                <label>资讯列表展示样式</label>
                <div class="radio-box">
						<span ng-click="changeStyle($event)">
							<input type="radio" name="goods-show" data-styleid="1" id="showstyle1" ng-checked="{{listStyle==1?true:false}}">
							<label for="showstyle1">上图下文</label>
                            <img src="/public/wxapp/images/style_1.png" />
						</span>
                    <span ng-click="changeStyle($event)">
							<input type="radio" name="goods-show" data-styleid="2" id="showstyle2" ng-checked="{{listStyle==2?true:false}}">
							<label for="showstyle2">一左一右</label>
                            <img src="/public/wxapp/images/style_2.png" />
						</span>
                    <span ng-click="changeStyle($event)">
							<input type="radio" name="goods-show" data-styleid="3" id="showstyle3" ng-checked="{{listStyle==3?true:false}}">
							<label for="showstyle3">左图右文</label>
                            <img src="/public/wxapp/images/style_3.png" />
						</span>
                    <span ng-click="changeStyle($event)">
							<input type="radio" name="goods-show" data-styleid="4" id="showstyle4" ng-checked="{{listStyle==4?true:false}}">
							<label for="showstyle4">左文右图</label>
                            <img src="/public/wxapp/images/style_4.png" />
						</span>
                    <span ng-click="changeStyle($event)">
							<input type="radio" name="goods-show" data-styleid="5" id="showstyle5" ng-checked="{{listStyle==5?true:false}}">
							<label for="showstyle5">高级版（信息流）</label>
                            <img src="/public/wxapp/images/style_5.png" />
						</span>
                </div>
            </div>
        </div>
    </div>
    <div class="alert alert-warning save-btn-box" role="alert"><button class="btn btn-blue btn-sm" ng-click="saveData()">  保 存 </button></div>
</div>
<script type="text/javascript" src="/public/plugin/layer/layer.js"></script>
<script src="/public/manage/shopfixture/color-spectrum/spectrum.js"></script>
<script src="/public/manage/newTemTwo/js/angular-1.4.6.min.js"></script>
<script src="/public/manage/newTemTwo/js/angular-root.js"></script>
<script>
    var app = angular.module('chApp', ['RootModule']);
    app.controller('chCtrl', ['$scope','$http',function($scope,$http){
        $scope.listStyle = <{$applet_cfg['ac_information_style']}>;
        console.log($scope.listStyle);
        console.log($scope.tpl);
        $scope.changeStyle=function($event){
            $event.preventDefault();
            var that =$($event.target).parents('span').find('input:eq(0)');
            var value = that.data('styleid');
            that.get(0).checked = true;
            $scope.listStyle = value;
            console.log($scope.listStyle);
        };
        $scope.saveData = function(){
            var index = layer.load(1, {
                shade: [0.1,'#fff'] //0.1透明度的白色背景
            },{
                time : 10*1000
            });

            var data = {
                'styleId' : $scope.listStyle
            };
            console.log(data);
            $http({
                method: 'POST',
                url:    '/wxapp/currency/saveInformationStyle',
                data:   data
            }).then(function(response) {
                layer.close(index);
                layer.msg(response.data.em);
            });
        };
    }]);
</script>
