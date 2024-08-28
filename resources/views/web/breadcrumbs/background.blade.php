<style>
    #breadcrumbs-section {
        width: 100%;
        position: relative;
        z-index: 0;
        overflow: hidden;
        height: auto;
        display: block;
        color: #fff;
        background-size: cover;
        background-image: url({{ $image }});
        background-attachment: scroll;
        padding: 100px 0;
    }
    #breadcrumbs-section:before {
        content: '';
        position: absolute;
        top: 0;
        right: 0;
        bottom: 0;
        left: 0;
        background-color: #222;
        z-index: -1;
        opacity: .75;
    }
    #breadcrumbs-content {
        padding-top: 320px;
        display: flex;
        position: relative;
    }
    #breadcrumbs-title {
        width: 50%;
    }
    #breadcrumbs-title > h1 {
        font-size: 48px;
        font-weight: 500;
    }
    #breadcrumbs-list {
        margin-left: auto;
        margin-top: auto;
        position: relative;
        font-size: 18px;
    }
    #breadcrumbs-list ol {
        margin: auto 0;
        margin-left: 12px;
        padding: 8px 0;
    }
    #breadcrumbs-list ol:before {
        content: " ";
        position: absolute;
        top: 0;
        left: 0;
        bottom: 0;
        width: 5px;
        height: 100%;
        background: var(--bs-white);
    }
    #breadcrumbs-section a {
        color: var(--bs-white);
    }
    .breadcrumb-item.active {
        color: var(--bs-white);
    }
    .breadcrumb-item + .breadcrumb-item::before {
        color: var(--bs-white);
    }
</style>

<section id="breadcrumbs-section">
    <div class="container-xl">
        <div id="breadcrumbs-content">
            <div id="breadcrumbs-title">
                <h1>{{ $caption }}</h1>
                <div>{{ $description }}</div>
            </div>
            <div id="breadcrumbs-list">
                {{ \Diglactic\Breadcrumbs\Breadcrumbs::view('web.breadcrumbs._data') }}
            </div>
        </div>
    </div>
</section>



