<?php

return array(
    'type'=> array(
        1 =>array(
            'label'   => '购物单',
            'content' => '<div class="shopping-box">
		<div class="shop-title">购物单</div>
		<div class="order-detail">
			<table cellpadding="0" cellspacing="0" border="0">
					<tr class="order-date">
						<td colspan="2">订单编号：{OrderNumber}</td>
						<td colspan="3" class="text-right">客户下单日期：{Date}</td>
						<td colspan="2" class="text-right">优惠金额：{Discount}</td>
					</tr>
					<tr class="detail">
						<td>订购商品名称</td>
						<td>单价</td>
						<td>数量</td>
						<td>小计</td>
					</tr><tbody>
					<tr class="detail">
						<td>{Goods}</td>
						<td>{Price}</td>
						<td>{Number}</td>
						<td>{Money}</td>
					</tr>
				</tbody>
			</table>
		</div>
	</div>',
        ),
        2 =>array(
            'label'   => '配货单',
            'content' => '<div class="packinglist-box">
        <div class="order-info clearfix">
            <p class="fl"></p>
            <p class="fr text-right">订单日期：{Date}</p>
        </div>
        <div class="order-info clearfix">
            <p class="fl"><span>联 系 人：</span>{Customer}</p>
            <p class="fr text-right">联系电话：{Phone}</p>
        </div>
        <div class="order-info clearfix">
            <p class="fl"><span>订 单 号：</span>{OrderNumber}</p>
            <p class="fr text-right">送货地址：{Address}</p>
        </div>
        <div class="order-detail">
            <table cellpadding="0" cellspacing="0" border="1">
                <thead>
                <tr>
                    <th>序号</th>
                    <th class="width-40">商品名称</th>
                    <th>数量</th>
                    <th>单价</th>
                    <th>小计</th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td>{Gid}</td>
                    <td>{Goods}</td>
                    <td>{Number}</td>
                    <td>{Price}</td>
                    <td>{Money}</td>
                </tr>
                </tbody>
                 <tr>
                    <td colspan="6" class="text-left subtotal">
                        <span>商品小计：<b>￥{totalMoney}</b></span>
                    </td>
                </tr>
            </table>
        </div>
    </div>',
        ),
    ),
    'typeSequence'=> array(
        1 =>array(
            'label'   => '购物单',
            'content' => '<div class="shopping-box">
		<div class="shop-title">购物单</div>
		<div class="order-detail">
			<table cellpadding="0" cellspacing="0" border="0">
					<tr class="order-date">
						<td colspan="2">订单编号：{OrderNumber}</td>
						<td colspan="2" class="text-right">客户下单日期：{Date}</td>
					</tr>
					<tr class="detail">
						<td>订购商品名称</td>
						<td>单价</td>
						<td>数量</td>
						<td>小计</td>
					</tr><tbody>
					<tr class="detail">
						<td>{Goods}</td>
						<td>{Number}</td>
						<td>{Price}</td>
						<td>{Money}</td>
					</tr>
				</tbody>
			</table>
		</div>
	</div>',
        ),
        2 =>array(
            'label'   => '配货单',
            'content' => '<div class="packinglist-box">
        <div class="order-info clearfix">
            <p class="fl"></p>
            <p class="fr text-right">订单日期：{Date}</p>
        </div>
        <div class="order-info clearfix">
            <p class="fl"><span>联 系 人：</span>{Customer}</p>
            <p class="fr text-right">联系电话：{Phone}</p>
        </div>
        <div class="order-info clearfix">
            <p class="fl"><span>订 单 号：</span>{OrderNumber}</p>
            <p class="fr text-right">送货地址：{Address}</p>
        </div>
        <div class="order-info clearfix">
            <p class="fl"><span>小　　区：</span>{Community}</p>
            <p class="fr text-right">小区地址：{CommunityAddr}</p>
        </div>
        <div class="order-detail">
            <table cellpadding="0" cellspacing="0" border="1">
                <thead>
                <tr>
                    <th>序号</th>
                    <th class="width-40">商品名称</th>
                    <th>数量</th>
                    <th>单价</th>
                    <th>小计</th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td>{Gid}</td>
                    <td>{Goods}</td>
                    <td>{Number}</td>
                    <td>{Price}</td>
                    <td>{Money}</td>
                </tr>
                </tbody>
                 <tr>
                    <td colspan="6" class="text-left subtotal">
                        <span>商品小计：<b>￥{totalMoney}</b></span>
                        <span>优惠金额：<b>￥{Discount}</b></span>
                    </td>
                </tr>
            </table>
        </div>
    </div>',
        ),
    ),
    'tag' => array(
        array(
            'label' => '商家备注',
            'field' => '{Remark}',
        ),
        array(
            'label' => '下单日期',
            'field' => '{Date}',
        ),
        array(
            'label' => '订单号',
            'field' => '{OrderNumber}',
        ),
        array(
            'label' => '付款方式',
            'field' => '{PayType}',
        ),
        array(
            'label' => '付款状态',
            'field' => '{PayStatus}',
        ),
        array(
            'label' => '总金额',
            'field' => '{totalMoney}',
        ),
        array(
            'label' => '优惠金额',
            'field' => '{Discount}',
        ),
        array(
            'label' => '客户',
            'field' => '{Customer}',
        ),
        array(
            'label' => '客户地址',
            'field' => '{Address}',
        ),
        array(
            'label' => '客户电话',
            'field' => '{Phone}',
        ),
    ),
    'tableTag' => array(
        array(
            'label' => '商品序号',
            'field' => '{Gid}',
        ),
        array(
            'label' => '商品名称',
            'field' => '{Goods}',
        ),
        array(
            'label' => '数量',
            'field' => '{Number}',
        ),
        array(
            'label' => '单价',
            'field' => '{Price}',
        ),
        array(
            'label' => '单品总价',
            'field' => '{Money}',
        ),
        array(
            'label' => '商品规格',
            'field' => '{GfName}',
        ),

    ),

    'printFormSeq'=> array(
        1 =>array(
            'label'   => '提货单',
            'content' => '<div class="packinglist-box">
        <div class="shop-title">提货单（{CommunityName}）</div>
        <div class="order-info clearfix">
            <p class="fl"><span>团长姓名：</span>{LeaderName}</p>
            <p class="fr text-right">团长电话：{LeaderMobile}</p>
        </div>
        <div class="order-info clearfix">
            <p class="fl"><span>配送时间：</span>{SendTime}</p>
            <p class="fr text-right">配送单号：{SendNumber}</p>
        </div>
        <div class="order-detail">
            <table cellpadding="0" cellspacing="0" border="1">
                <thead>
                <tr>
                    <td>下单时间</td>
					<td>联系人</td>
					<td>商品名称</td>
					<td>规格</td>
					<td>商品数量</td>
					<td>商品金额</td>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td>{OrderTime}</td>
					<td>{MemberName}</td>
					<td>{GoodsName}</td>
					<td>{GoodsFormat}</td>
					<td>{GoodsNum}</td>
					<td>{GoodsMoney}</td>
                </tr>
                </tbody>
                 <tr>
                     <td colspan="6" style="text-align: center">
                        {CommunityName}（客服电话：{Shopphone}）
                     </td>
                 </tr>
            </table>
        </div>
    </div>',
        ),
        2 =>array(
            'label'   => '交货单',
            'content' => '<div class="packinglist-box">
        <div class="shop-title">交货单（{CommunityName}）</div>
        <div class="order-info clearfix">
            <p class="fl">线路名称：{LineName}</p>
            <p class="fl">团长姓名：{LeaderName}</p>
            <p class="fl">团长电话：{LeaderMobile}</p>
        </div>
        <div class="order-info clearfix">
            <p class="fl">配送员电话：{LineMobile}</p>
            <p class="fl">公司电话：{Shopphone}</p>
            <p class="fl">商品总数：{GoodsTotal}</p>
        </div>
        <div class="order-info clearfix">
            <p class="fl">配送时间：{SendTime}</p>
            <p class="fl">配送单号：{SendNumber}</p>
            <p class="fl">社区名称：{CommunityName}</p>
        </div>
        <div>
			<p class="">社区地址：{CommunityAddress}</p>
		</div>
        <div class="order-detail">
            <table cellpadding="0" cellspacing="0" border="1">
                <thead>
                <tr>
					<td>商品分类</td>
					<td>商品名称</td>
					<td>规格</td>
					<td>商品数量</td>
					<td class="width-10">备注</td>
                </tr>
                </thead>
                <tbody>
                <tr>
					<td>{GoodsCategory}</td>
					<td>{GoodsName}</td>
					<td>{GoodsFormat}</td>
					<td>{GoodsNum}</td>
					<td>{GoodsMoney}</td>
                </tr>
                </tbody>
                 <tr>
                     <td colspan="5" style="text-align: center">
                        {CommunityName}
                     </td>
                 </tr>
            </table>
            <div class="hand-write">
				<div class="hand-write-sign">
					团长签字：
				</div>
				<div class="">
					日期：
				</div>
			</div>
			<div class="hand-write">
				<div class="hand-write-sign">
					配送员签字：
				</div>
				<div class="">
					日期：
				</div>
			</div>
        </div>
    </div>',
        ),
        3 =>array(
            'label'   => '分拣配货单',
            'content' => '<div class="packinglist-box">
        <div class="shop-title">分拣配货单</div>
        <div class="order-info clearfix">
            <p class="fl">配送时间：{SendTime}</p>
            <p class="fl">配送单号：{SendNumber}</p>
            <p class="fl">公司电话：{Shopphone}</p>
        </div>
        <div class="order-info clearfix">
            <p class="fl">商品总数：{GoodsTotal}</p>
        </div>
        <div class="order-detail">
            <table cellpadding="0" cellspacing="0" border="1">
                <thead>
                <tr>
					<td>商品名称</td>
					<td>小区名称</td>
					<td>商品数量</td>
					<td class="width-10">备注</td>
                </tr>
                </thead>
                <tbody>
                <tr>
					
                </tr>
                </tbody>
            </table>
			<div class="hand-write">
				<div class="hand-write-sign">
					签字：
				</div>
				<div class="">
					日期：
				</div>
			</div>
        </div>
    </div>',
        ),
    ),


    'printWordSeq'=> array(
        1 =>array(
            'label'   => '提货单',
            'content' => '<div class="packinglist-box" style="width: 100%;margin:0 auto;margin-top: 10px;font-weight: bold">
        <div class="shop-title" style="color: #000;font-size: 16px;text-align: center;padding: 10px 0;">提货单（{CommunityName}）</div>
        <table style="width: 100%;margin-bottom: 20px;font-size: 13px;font-weight: bold" rules=none cellspacing=0>
            <tr>
                <td style="padding:2px;">线路名称：{LineName}</td>
                <td style="padding:2px;">团长姓名：{LeaderName}</td>
                <td style="padding:2px;">团长电话：{LeaderMobile}</td>
            </tr>
            <tr>
                <td style="padding:2px;">配送员电话：{LineMobile}</td>
                <td style="padding:2px;">公司电话：{Shopphone}</td>
                <td style="padding:2px;">商品总数：{GoodsTotal}</td>
            </tr>
            <tr>
                <td style="padding:2px;">配送时间：{SendTime}</td>
                <td style="padding:2px;">配送单号：{SendNumber}</td>
                <td style="padding:2px;">社区名称：{CommunityName}</td>
            </tr>
            <tr>
                <td style="padding:2px;" colspan="3">社区地址：{CommunityAddress}</td>
            </tr>
        </table>
        <div style="height: 8px">
        
        </div>
        <div class="order-detail" style="margin-top: 5px;">
            <table cellpadding="0" cellspacing="0" border="1" style="width:100%;word-break:break-all;border-collapse:collapse;font-size: 10px;font-weight: bold"> 
                <thead>
                <tr>
                    <th style="text-align:center;padding:2px;border: 1.4px solid;width: 7%">序号</th>
                    <th style="text-align:center;padding:2px;border: 1.4px solid;width: 12%">下单时间</th>
					<th style="text-align:center;padding:2px;border: 1.4px solid;width: 12%">联系人</th>
					<th style="text-align:center;padding:2px;border: 1.4px solid;width: 10%">电话</th>
					<th style="text-align:center;padding:2px;border: 1.4px solid">商品名称</th>
					<th style="text-align:center;padding:2px;border: 1.4px solid">商品数量</th>
					<th style="text-align:center;padding:2px;border: 1.4px solid">规格</th>
					<th style="text-align:center;padding:2px;border: 1.4px solid;width: 9%">商品金额</th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td>{RowNum}</td>
                    <td>{OrderTime}</td>
					<td>{MemberName}</td>
					<td>{MemberPhone}</td>
					<td>{GoodsName}</td>
					<td>{GoodsNum}</td>
					<td>{GoodsFormat}</td>
					<td>{GoodsMoney}</td>
                </tr>
                </tbody>
                 <tr>
                     <td colspan="8" style="text-align: center;border: 1.4px solid #000">
                        {CommunityName}（客服电话：{Shopphone}）
                     </td>
                 </tr>
            </table>
        </div>
    </div>',
        ),
        2 =>array(
            'label'   => '交货单',
            'content' => '<div class="packinglist-box" style="width: 100%;margin:0 auto;margin-top: 10px;font-weight: bold">
        <div class="shop-title" style="color: #000;font-size: 16px;text-align: center;padding: 10px 0;">交货单（{CommunityName}）</div>
        <table style="width: 100%;margin-bottom: 20px;font-size: 13px;font-weight: bold" rules=none cellspacing=0>
            <tr>
                <td style="padding:2px;">线路名称：{LineName}</td>
                <td style="padding:2px;">团长姓名：{LeaderName}</td>
                <td style="padding:2px;">团长电话：{LeaderMobile}</td>
            </tr>
            <tr>
                <td style="padding:2px;">配送员电话：{LineMobile}</td>
                <td style="padding:2px;">公司电话：{Shopphone}</td>
                <td style="padding:2px;">商品总数：{GoodsTotal}</td>
            </tr>
            <tr>
                <td style="padding:2px;">配送时间：{SendTime}</td>
                <td style="padding:2px;">配送单号：{SendNumber}</td>
                <td style="padding:2px;">社区名称：{CommunityName}</td>
            </tr>
            <tr>
                <td style="padding:2px;" colspan="3">社区地址：{CommunityAddress}</td>
            </tr>
        </table>
        <div style="height: 8px">
        
        </div>
        <div class="order-detail" style="margin-top: 5px;">
            <table cellpadding="0" cellspacing="0" border="2" style="width:100%;word-break:break-all;border-collapse:collapse;font-size: 10px;font-weight: bold" >
                <thead>
                <tr>
                    <th style="text-align:center;padding:2px;border: 1.4px solid;width: 7%">序号</th>
					<td style="text-align:center;padding:2px;border: 1.4px solid;width: 12%">商品分类</td>
					<td style="text-align:center;padding:2px;border: 1.4px solid">商品名称</td>
					<td style="text-align:center;padding:2px;border: 1.4px solid">商品数量</td>
					<td style="text-align:center;padding:2px;border: 1.4px solid">规格</td>
					<td style="text-align:center;padding:2px;border: 1.4px solid;width: 10%">备注</td>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td>{RowNum}</td>
					<td>{GoodsCategory}</td>
					<td>{GoodsName}</td>
					<td>{GoodsNum}</td>
					<td>{GoodsFormat}</td>
					<td>{GoodsMoney}</td>
                </tr>
                </tbody>
                 <tr>
                     <td colspan="6" style="text-align: center;border: 1.4px solid #000">
                        {CommunityName}
                     </td>
                 </tr>
            </table>
            <div class="hand-write" style="font-size: 14px">
				团长确认以上商品均收到后，请签字，若有破损请备注
			</div>
            <div class="hand-write" style="font-size: 14px">
				<div class="hand-write-sign" style="display:inline-block;margin:7px;width: 30%">
					团长签字：
				</div>
				<div class="" style="display:inline-block;margin:7px">
					日期：
				</div>
			</div>
			<div class="hand-write" style="font-size: 14px" >
				<div class="hand-write-sign" style="display:inline-block;margin:7px;width: 30%">
					配送员签字：
				</div>
				<div class="" style="display:inline-block;margin:7px">
					日期：
				</div>
			</div>
        </div>
    </div>',
        ),
        3 =>array(
            'label'   => '分拣配货单',
            'content' => '<div class="packinglist-box" style="width: 100%;margin:0 auto;margin-top: 10px;font-weight: bold">
        <div class="shop-title" style="color: #000;font-size: 16px;text-align: center;padding: 10px 0;">分拣配货单</div>
        <table style="width: 100%;margin-bottom: 20px;font-size: 13px;font-weight: bold" rules=none cellspacing=0>
            <tr>
                <td style="padding:2px;">配送时间：{SendTime}</td>
                <td style="padding:2px;">公司电话：{Shopphone}</td>
            </tr>
            <tr>
                <td style="padding:2px;">配送单号：{SendNumber}</td>
                <td style="padding:2px;">商品总数：{GoodsTotal}</td>
            </tr>
            <tr>
                <td colspan="2"></td>
            </tr>
        </table>
       
        
        
        <div class="order-detail" style="margin-top: 5px;">
            <table cellpadding="0" cellspacing="0" border="1" style="width:100%;word-break:break-all;border-collapse:collapse;font-size: 10px;font-weight: bold">
                <thead>
                <tr>
                    <th style="text-align:center;padding:2px;border: 1.4px solid;width: 7%">序号</th>
                    <td style="text-align:center;padding:2px;border: 1.4px solid;width: 12%">商品分类</td>
					<td style="text-align:center;padding:2px;border: 1.4px solid;width: 40%">商品名称</td>
					<td style="text-align:center;padding:2px;border: 1.4px solid;width: 13%">小区名称</td>
					<td style="text-align:center;padding:2px;border: 1.4px solid">商品数量</td>
					<td style="text-align:center;padding:2px;border: 1.4px solid;width: 12%">商品总数</td>
					<td style="text-align:center;padding:2px;border: 1.4px solid;width: 10%">备注</td>
                </tr>
                </thead>
                <tbody>
                <tr>
					
                </tr>
                </tbody>
            </table>

			<div class="hand-write" style="font-size: 14px;width: 100%">
				<div class="hand-write-sign" style="display:inline-block;margin:7px;width: 30%">
					分拣员签字：
				</div>
				<div class="" style="display:inline-block;margin:7px;width: 30%">
					日期：
				</div>
			</div>
			<div class="hand-write" style="font-size: 14px;width: 100%">
				<div class="hand-write-sign" style="display:inline-block;margin:7px;width: 30%">
					仓库主管签字：
				</div>
				<div class="" style="display:inline-block;margin:7px;width: 30%">
					日期：
				</div>
			</div>
        </div>
    </div>',
        ),
    ),

    'printWordSeqCustom'=> array(
        1 =>array(
            'label'   => '提货单',
            'content' => '<div class="packinglist-box" style="width: 100%;margin:0 auto;margin-top: 10px;font-weight: bold">
        <div class="shop-logo" style="width: 100%;text-align: center"><img src="{ShopLogo}" style="margin-left: auto;margin-right: auto;width: 30%" /></div>
        <div class="shop-title" style="color: #000;font-size: 16px;text-align: center;padding: 10px 0;">提货单（{CommunityName}）</div>
        <table style="width: 100%;margin-bottom: 20px;font-size: 13px;font-weight: bold" rules=none cellspacing=0>
            <tr>
                <td style="padding:2px;">线路名称：{LineName}</td>
                <td style="padding:2px;">团长姓名：{LeaderName}</td>
                <td style="padding:2px;">团长电话：{LeaderMobile}</td>
            </tr>
            <tr>
                <td style="padding:2px;">配送员电话：{LineMobile}</td>
                <td style="padding:2px;">公司电话：{Shopphone}</td>
                <td style="padding:2px;">商品总数：{GoodsTotal}</td>
            </tr>
            <tr>
                <td style="padding:2px;">配送时间：{SendTime}</td>
                <td style="padding:2px;">配送单号：{SendNumber}</td>
                <td style="padding:2px;">社区名称：{CommunityName}</td>
            </tr>
            <tr>
                <td style="padding:2px;" colspan="3">社区地址：{CommunityAddress}</td>
            </tr>
            <tr>
                <td colspan="3"> </td>
            </tr>
        </table>
        <div class="order-detail" style="margin-top: 5px;">
            <table cellpadding="0" cellspacing="0" border="1" style="width:100%;word-break:break-all;border-collapse:collapse;font-size: 10px;font-weight: bold"> 
                <thead>
                <tr>
                    <th style="text-align:center;padding:2px;border: 1.4px solid;width: 7%">序号</th>
                    <th style="text-align:center;padding:2px;border: 1.4px solid;width: 12%">下单时间</th>
					<th style="text-align:center;padding:2px;border: 1.4px solid;width: 12%">联系人</th>
					<th style="text-align:center;padding:2px;border: 1.4px solid;width: 10%">电话</th>
					<th style="text-align:center;padding:2px;border: 1.4px solid">商品名称</th>
					<th style="text-align:center;padding:2px;border: 1.4px solid">商品数量</th>
					<th style="text-align:center;padding:2px;border: 1.4px solid">规格</th>
					<th style="text-align:center;padding:2px;border: 1.4px solid;width: 9%">商品金额</th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td>{RowNum}</td>
                    <td>{OrderTime}</td>
					<td>{MemberName}</td>
					<td>{MemberPhone}</td>
					<td>{GoodsName}</td>
					<td>{GoodsNum}</td>
					<td>{GoodsFormat}</td>
					<td>{GoodsMoney}</td>
                </tr>
                </tbody>
                 <tr>
                     <td colspan="8" style="text-align: center;border: 1.4px solid #000">
                        {CommunityName}（客服电话：{Shopphone}）
                     </td>
                 </tr>
            </table>
        </div>
    </div>',
        ),
        2 =>array(
            'label'   => '交货单',
            'content' => '<div class="packinglist-box" style="width: 100%;margin:0 auto;margin-top: 10px;font-weight: bold">
        <div class="shop-logo" style="width: 100%;text-align: center"><img src="{ShopLogo}" style="margin-left: auto;margin-right: auto;width: 30%" /></div>
        <div class="shop-title" style="color: #000;font-size: 16px;text-align: center;padding: 10px 0;">交货单（{CommunityName}）</div>
        <table style="width: 100%;margin-bottom: 20px;font-size: 13px;font-weight: bold" rules=none cellspacing=0>
            <tr>
                <td style="padding:2px;">线路名称：{LineName}</td>
                <td style="padding:2px;">团长姓名：{LeaderName}</td>
                <td style="padding:2px;">团长电话：{LeaderMobile}</td>
            </tr>
            <tr>
                <td style="padding:2px;">配送员电话：{LineMobile}</td>
                <td style="padding:2px;">公司电话：{Shopphone}</td>
                <td style="padding:2px;">商品总数：{GoodsTotal}</td>
            </tr>
            <tr>
                <td style="padding:2px;">配送时间：{SendTime}</td>
                <td style="padding:2px;">配送单号：{SendNumber}</td>
                <td style="padding:2px;">社区名称：{CommunityName}</td>
            </tr>
            <tr>
                <td style="padding:2px;" colspan="3">社区地址：{CommunityAddress}</td>
            </tr>
            <tr>
                <td colspan="3"> </td>
            </tr>
        </table>
        <div style="height: 8px">
        
        </div>
        <div class="order-detail" style="margin-top: 5px;">
            <table cellpadding="0" cellspacing="0" border="2" style="width:100%;word-break:break-all;border-collapse:collapse;font-size: 10px;font-weight: bold" >
                <thead>
                <tr>
                    <th style="text-align:center;padding:2px;border: 1.4px solid;width: 7%">序号</th>
					<td style="text-align:center;padding:2px;border: 1.4px solid;width: 12%">商品分类</td>
					<td style="text-align:center;padding:2px;border: 1.4px solid">商品名称</td>
					<td style="text-align:center;padding:2px;border: 1.4px solid">商品数量</td>
					<td style="text-align:center;padding:2px;border: 1.4px solid">规格</td>
					<td style="text-align:center;padding:2px;border: 1.4px solid;width: 10%">备注</td>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td>{RowNum}</td>
					<td>{GoodsCategory}</td>
					<td>{GoodsName}</td>
					<td>{GoodsNum}</td>
					<td>{GoodsFormat}</td>
					<td>{GoodsMoney}</td>
                </tr>
                </tbody>
                 <tr>
                     <td colspan="6" style="text-align: center;border: 1.4px solid #000">
                        {CommunityName}
                     </td>
                 </tr>
            </table>
            <div class="hand-write" style="font-size: 14px">
				团长确认以上商品均收到后，请签字，若有破损请备注
			</div>
            <div class="hand-write" style="font-size: 14px">
				<div class="hand-write-sign" style="display:inline-block;margin:7px;width: 30%">
					团长签字：
				</div>
				<div class="" style="display:inline-block;margin:7px">
					日期：
				</div>
			</div>
			<div class="hand-write" style="font-size: 14px" >
				<div class="hand-write-sign" style="display:inline-block;margin:7px;width: 30%">
					配送员签字：
				</div>
				<div class="" style="display:inline-block;margin:7px">
					日期：
				</div>
			</div>
        </div>
    </div>',
        ),
        3 =>array(
            'label'   => '分拣配货单',
            'content' => '<div class="packinglist-box" style="width: 100%;margin:0 auto;margin-top: 10px;font-weight: bold">
        <div class="shop-logo" style="width: 100%;text-align: center"><img src="{ShopLogo}" style="margin-left: auto;margin-right: auto;width: 30%" /></div>
        <div class="shop-title" style="color: #000;font-size: 16px;text-align: center;padding: 10px 0;">分拣配货单</div>
        <table style="width: 100%;margin-bottom: 20px;font-size: 13px;font-weight: bold" rules=none cellspacing=0>
            <tr>
                <td style="padding:2px;">配送时间：{SendTime}</td>
                <td style="padding:2px;">公司电话：{Shopphone}</td>
            </tr>
            <tr>
                <td style="padding:2px;">配送单号：{SendNumber}</td>
                <td style="padding:2px;">商品总数：{GoodsTotal}</td>
            </tr>
            <tr>
                <td colspan="2"></td>
            </tr>
        </table>
       
        
        
        <div class="order-detail" style="margin-top: 5px;">
            <table cellpadding="0" cellspacing="0" border="1" style="width:100%;word-break:break-all;border-collapse:collapse;font-size: 10px;font-weight: bold">
                <thead>
                <tr>
                    <th style="text-align:center;padding:2px;border: 1.4px solid;width: 7%">序号</th>
                    <td style="text-align:center;padding:2px;border: 1.4px solid;width: 12%">商品分类</td>
					<td style="text-align:center;padding:2px;border: 1.4px solid;width: 40%">商品名称</td>
					<td style="text-align:center;padding:2px;border: 1.4px solid;width: 13%">小区名称</td>
					<td style="text-align:center;padding:2px;border: 1.4px solid">商品数量</td>
					<td style="text-align:center;padding:2px;border: 1.4px solid;width: 12%">商品总数</td>
					<td style="text-align:center;padding:2px;border: 1.4px solid;width: 10%">备注</td>
                </tr>
                </thead>
                <tbody>
                <tr>
					
                </tr>
                </tbody>
            </table>

			<div class="hand-write" style="font-size: 14px;width: 100%">
				<div class="hand-write-sign" style="display:inline-block;margin:7px;width: 30%">
					分拣员签字：
				</div>
				<div class="" style="display:inline-block;margin:7px;width: 30%">
					日期：
				</div>
			</div>
			<div class="hand-write" style="font-size: 14px;width: 100%">
				<div class="hand-write-sign" style="display:inline-block;margin:7px;width: 30%">
					仓库主管签字：
				</div>
				<div class="" style="display:inline-block;margin:7px;width: 30%">
					日期：
				</div>
			</div>
        </div>
    </div>',
        ),
    ),

    'logoPath' => '/public/site/new/img/logo.png',
//    'logoPath' => '/public/site/img/custom_logo.png'

    'default_cfg' => [
        'apc_discounts_isprint' => 0,
        'apc_discounts_bold' => 0,
        'apc_total_isprint' => 1,
        'apc_total_bold' => 1,
        'apc_code_isprint' => 1,
        'apc_code_bold' => 0,
        'apc_remark_isprint' => 1,
        'apc_remark_bold' => 0,
        'apc_receiver_isprint' => 1,
        'apc_receiver_bold' => 0,
        'apc_address_isprint' => 1,
        'apc_address_bold' => 0,
        'apc_customs_isprint' => 1,
        'apc_customs_bold' => 0,
        'apc_activity_isprint' => 0,
        'apc_activity_bold' => 0,
        'apc_community_isprint' => 0,
        'apc_community_bold' => 0,
        'apc_leader_isprint' => 0,
        'apc_leader_bold' => 0,
        'apc_receivetime_isprint' => 0,
        'apc_receivetime_bold' => 0,
        'apc_senddate_isprint' => 0,
        'apc_senddate_bold' => 0,
        'apc_esname_isprint' => 0,
        'apc_esname_bold' => 0,
        'apc_esphone_isprint' => 0,
        'apc_esphone_bold' => 0,
        'apc_time_isprint' => 1,
        'apc_time_bold' => 0,
        'apc_comaddr_isprint' => 0,
        'apc_comaddr_bold' => 0,
        'apc_paytype_isprint' => 0,
        'apc_paytype_bold' => 0,
        'apc_print_type' => 1,
        'apc_print_num' => 1,
        'apc_qrcode_isprint' => 0,
        'apc_goods_large' => 0,
        'apc_postfee_isprint' => 0,
        'apc_postfee_bold' => 0,
        'apc_legworknum_isprint' => 0,
        'apc_legworknum_bold' => 0,
        'apc_tablenum_large' => 0,
    ],

);