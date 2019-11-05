/*jshint esversion: 6 */

class Slider
{


    constructor(target, duration)
    {
        this.slider = document.querySelector("." + target);
        this.currentSlide = 0;
        this.slides = [];
        this.slideId = 0;
        this.sliderPaused = false;
        this.sliderUpdate = null;
        this.duration = duration;

        let pauseBtn = document.createElement("i");
        pauseBtn.className = "fas fa-pause";
        pauseBtn.id = "pause";
        pauseBtn.addEventListener("click", () =>
        {
            this.sliderPause();
        });
        this.slider.appendChild(pauseBtn);

        let prevBtn = document.createElement("i");
        prevBtn.className = "fas fa-arrow-circle-left";
        prevBtn.id = "prev";
        prevBtn.addEventListener("click", () =>
        {
            this.switchSlides("prev");
        });
        this.slider.appendChild(prevBtn);

        let nextBtn = document.createElement("i");
        nextBtn.className = "fas fa-arrow-circle-right";
        nextBtn.id = "next";
        nextBtn.addEventListener("click", () =>
        {
            this.switchSlides();
        });
        this.slider.appendChild(nextBtn);
        document.addEventListener('keyup', e =>
        {
            if (e.code == 'ArrowRight')
            {
                this.switchSlides();
            }
            else if (e.code == 'ArrowLeft')
            {
                this.switchSlides("prev");
            }
        });
    }
    
    createSlide(url, text)
    {
        let slide = document.createElement("div");
        let image = document.createElement("img");
        let caption = document.createElement("p");
        slide.classList.add("slide");
        image.setAttribute("src", url);
        caption.textContent = text;
        slide.appendChild(caption);
        slide.appendChild(image);
        this.slider.appendChild(slide);
    }

    initSlider()
    {
        
        this.slides = document.getElementsByClassName("slide");
        
        for (let i = 0; i < this.slides.length; i++)
        {
            this.slides[i].style.opacity = 0;
        }
        
        this.slides[0].style.opacity = 1;
        this.slides[0].style.zIndex = 1;
        
        this.sliderUpdate = setInterval(() =>
        {
            this.switchSlides();
        }, this.duration);
    }

    switchSlides(direction)
    {
        
        this.slides[this.currentSlide].style.opacity = 0;
        this.slides[this.currentSlide].style.zIndex = 0;
        if(direction == "prev")
        {
            if (this.currentSlide == 0)
            {
                this.currentSlide = this.slides.length - 1;
                this.slides[this.currentSlide].style.opacity = 1;
            }
            else
            {
                this.slides[--this.currentSlide].style.opacity = 1;
            }
        }
        else
        {
            if (this.currentSlide == this.slides.length - 1)
            {
                this.currentSlide = 0;
                this.slides[this.currentSlide].style.opacity = 1;
            }
            else
            {
                this.slides[++this.currentSlide].style.opacity = 1;
            }
        }
        this.slides[this.currentSlide].style.zIndex = 1;
        this.resetTimer();
    }

    sliderPause()
    {
        if (this.sliderPaused)
        {
            this.sliderPaused = false;
            this.resetTimer();
            document.getElementById("pause").className = "fas fa-pause";
        }
        else
        {
            clearInterval(this.sliderUpdate);
            this.sliderPaused = true;
            document.getElementById("pause").className = "fas fa-play";
        }
    }

    resetTimer()
    {
        if (this.sliderPaused == false)
        {
            clearInterval(this.sliderUpdate);
            this.sliderUpdate = setInterval(() =>
            {
                this.switchSlides();
            }, this.duration);
        }
    }
}

