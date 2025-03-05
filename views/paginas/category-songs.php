<main class="container">
    <?php if (isset($genero)) : ?>
        <h1>{%t-genre%}:
            <span class="text-green caps">
                <?php if($lang == 'en'){
                    echo $genero->genero_en;
                    }else{
                        echo $genero->genero_es;
                    }
                ?>
            </span>
        </h1>
    <?php elseif(isset($categoria)): ?>
        <h1>{%t-category%}:
            <span class="text-green caps">
                <?php if($lang == 'en'){
                    echo $categoria->keyword_en;
                    }else{
                        echo $categoria->keyword_es;
                    }
                ?>
            </span>
        </h1>
    <?php endif; ?>

    <?php if (isset($genero)) : ?>
        <a href="/category/genres" class="btn-back">{%genres_back-btn%}</a>
    <?php else :?>
        <a href="/category?id=<?php echo $cid;?>&name=<?php echo $name?>" class="btn-back">{%categories_back-btn%}</a>
    <?php endif; ?>
    <div class="dashboard__search  mBottom-5">
        <input class="dashboard__total__type-search" type="text" id="category-songs-search" placeholder="{%search_by_name%}"/>
    </div>
    <section class="p-cards__grid" id="grid-category-songs">
    </section>
</main>
