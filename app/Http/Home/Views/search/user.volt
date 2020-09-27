{{ partial('macros/user') }}

{% if pager.total_pages > 0 %}
    <div class="search-user-list">
        {% for item in pager.items %}
            {% set user_url = url({'for':'home.user.show','id':item.id}) %}
            {% set item.about = item.about ? item.about : '这个家伙真懒，什么也没有留下！' %}
            <div class="search-group-card clearfix">
                <div class="avatar">
                    <a href="{{ user_url }}">
                        <img src="{{ item.avatar }}!avatar_160" alt="{{ item.name }}">
                    </a>
                </div>
                <div class="info">
                    <div class="name layui-elip">
                        <a href="{{ user_url }}">{{ item.name }}</a>
                    </div>
                    <div class="about layui-elip">{{ item.about }}</div>
                    <div class="meta">
                        <span>性别：{{ gender_info(item.gender) }}</span>
                        <span>地区：{{ item.area }}</span>
                    </div>
                </div>
            </div>
        {% endfor %}
    </div>
{% else %}
    {{ partial('search/empty') }}
{% endif %}
