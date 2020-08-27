<div class="region region-content">
    <section id="block-system-main" class="block block-system clearfix">
        <table class="dblog-event table table-striped">
            <tbody>
                <tr class="even">
                    <th>日期</th>
                    <td><{$row['mol_create_time']|date_format:"%Y-%m-%d %H:%M:%S"}></td>
                </tr>
                <tr class="odd">
                    <th>操作人</th>
                    <td><{$row['m_nickname']}></td>
                </tr>
                <tr class="odd">
                    <th>来源</th>
                    <td><{$row['mol_url']}></td>
                </tr>
                <tr class="even">
                    <th>操作信息</th>
                    <td><{$row['mol_message']}></td>
                </tr>
                <{if $row['mol_change_data']}>
                <tr class="even">
                    <th>操作详情</th>
                    <td>
                        <{foreach $row['mol_change_data'] as $val}>
                            <{$val['title']}>由【<{$val['oldValue']}>】 修改为 【<{$val['newValue']}>】 <br>
                        <{/foreach}>
                    </td>
                </tr>
                <{/if}>
                <tr class="even">
                    <th>操作IP</th>
                    <td><{$row['mol_ip']}></td>
                </tr>
            </tbody>
        </table>
    </section>
</div>