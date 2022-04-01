<?php

namespace App\Interfaces;

interface SliderRepositoryInterface
{
  public function getFilteredSliders($request);
  public function getSliderById($sliderId);
  public function createSlider($request);
  public function updateSlider($request, $slider);
  public function deleteSlider($slider);
}
