<?php

  $couples = [
    'Joe &amp; Jane',
    'Tarzan &amp; Jane',
    'Phillip &amp; Jane',
    'John &amp; Jane',
    'Patrick &amp; Barb',
  ];

  $couplesCopy = [
    'blanditiis vero quam, cupiditate ullam facere corporis.',
    'Lorem ipsum dolor sit amet, consectetur adipisicing elit.',
    'Aspernatur ratione blanditiis vero quam distinctio reprehenderit.',
    'ad cum recusandae, cupiditate ullam facere corporis animi veniam.',
    'Animi eum quod necessitatibus explicabo eius.'
  ];

  $thumbnailArray = [
    "http://placekitten.com/849/748",
    "http://placekitten.com/752/752",
    "http://placekitten.com/752/759",
    "http://placekitten.com/749/742",
    "http://placekitten.com/758/701",
  ];

  $slidersArray = [
    [
      "http://placekitten.com/849/748",
      "http://placekitten.com/850/750",
      "http://placekitten.com/850/740",
      "http://placekitten.com/720/750"
    ],
    [
      "http://placekitten.com/752/752",
      "http://placekitten.com/751/751",
      "http://placekitten.com/731/771",
      "http://placekitten.com/791/721"
    ],
    [
      "http://placekitten.com/752/759",
      "http://placekitten.com/752/758",
      "http://placekitten.com/791/721"
    ],
    [
      "http://placekitten.com/749/742",
      "http://placekitten.com/749/743",
      "http://placekitten.com/732/771",
      "http://placekitten.com/791/771"
    ],
    [
      "http://placekitten.com/758/701",
      "http://placekitten.com/758/752",
      "http://placekitten.com/631/771",
      "http://placekitten.com/701/751",
      "http://placekitten.com/631/771"
    ]
  ];

?>

<?php $className = 'portfolio-slider' ?>
<div class="<?= $className ?>">
  <div class="portfolio-slider__left-cont">
    <p class="portfolio-slider__left-cont__title">
      Engagements
    </p>
    
    <div class="portfolio-slider__left-cont__name-cont">
      <p class="portfolio-slider__left-cont__name-cont__name">
        <?php foreach($couples as $key => $couple): ?>
          <span class="js-people-names<?= $key === 0 ? ' active' : null ?>"><?= $couple ?></span>
        <?php endforeach ?>
      </p>

      <div class="portfolio-slider__left-cont__name-cont__controls">
        <i class="portfolio-slider__left-cont__name-cont__controls__prev js-group-prev">
          <svg width="11" height="10" viewBox="0 0 11 10" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M-2.09808e-05 4.47761L10.8333 0V10L-2.09808e-05 4.47761Z" fill="#444444"/>
          </svg>
        </i>
        <i class="portfolio-slider__left-cont__name-cont__controls__next js-group-next">
          <svg width="11" height="10" viewBox="0 0 11 10" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M10.8333 4.47761L-7.62939e-06 0V10L10.8333 4.47761Z" fill="#444444"/>
          </svg>
        </i>
      </div>
    </div>
    
    <div class="portfolio-slider__left-cont__grid js-grid">
      <div class="portfolio-slider__left-cont__grid__copy">
        <?php foreach($couplesCopy as $key => $copy): ?>
          <p class="js-grid-copy<?= $key === 0 ? ' active' : null ?>"><?= $copy ?></p>
        <?php endforeach ?>
      </div>

      <?php foreach($thumbnailArray as $key => $thumb): ?>
        <div class="portfolio-slider__left-cont__grid__person js-people<?= $key === 0 ? ' active' : null ?>">
          <img src="<?= $thumb ?>" alt="" />
        </div>
      <?php endforeach ?>
    </div>
  </div>
  
  <div class="portfolio-slider__image-slider-cont">
    <?php foreach($slidersArray as $i => $sliderArray): ?>
      <div class="portfolio-slider__image-slider-cont__slider js-image-slider<?= $i === 0 ? ' active' : null ?>">
        <div class="portfolio-slider__image-slider-cont__slider__controls-cont">
          <i class="portfolio-slider__image-slider-cont__slider__controls-cont__prev js-prev">
            <svg width="11" height="10" viewBox="0 0 11 10" fill="none" xmlns="http://www.w3.org/2000/svg">
              <path d="M-2.09808e-05 4.47761L10.8333 0V10L-2.09808e-05 4.47761Z" fill="#444444"/>
            </svg>
          </i>
          <p class="portfolio-slider__image-slider-cont__slider__controls-cont__index">
            <span class="js-current-image-num">1</span>
            /
            <span class="js-total-image-num">4</span>
          </p>
          <i class="portfolio-slider__image-slider-cont__slider__controls-cont__next js-next">
            <svg width="11" height="10" viewBox="0 0 11 10" fill="none" xmlns="http://www.w3.org/2000/svg">
              <path d="M10.8333 4.47761L-7.62939e-06 0V10L10.8333 4.47761Z" fill="#444444"/>
            </svg>
          </i>
        </div>
        
        <?php foreach($sliderArray as $i => $image): ?>
          <img src="<?= $image ?>" alt="" class="js-slide<?= $i === 0 ? ' active' : null ?>" />
        <?php endforeach; ?>
      </div>
    <?php endforeach; ?>
  </div>
</div>