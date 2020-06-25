<!-- 侧边栏 -->
<div class="col-xl-4">
<div class="lyear-sidebar">
    <?php if(is_page() && is_active_sidebar('widget_page')) : ?>
        <?php dynamic_sidebar('widget_page'); ?> 
    <?php elseif(is_single() && is_active_sidebar('widget_single')): ?>
        <?php dynamic_sidebar('widget_single'); ?> 
    <?php elseif(is_active_sidebar('widget_default')): ?>
        <?php dynamic_sidebar('widget_default'); ?> 
    <?php else: ?>
        <aside class="widget">
            <div class="widget-title">主题侧栏</div>
            <p>请前往 <code>后台 > 外观 > 小工具</code> 配置主题侧边栏</p>
        </aside>
    <?php endif; ?>
</div>
</div>
<!-- 侧边栏 end -->