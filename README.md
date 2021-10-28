# 4WW3Project

Course name: Web Computing and Web Systems

Group name: WhereToEat

Member1: Tianyi Zhang zhangt73 400112525

Link: http://44.198.227.245/

Github Repository Link: https://github.com/tywin1104/4WW3Project

---

Assignment 1:
Add-on task 1 & 2 included

Answers for add-on task 2:

1. Here I was using picture tag to include multiple images of different resolution and let it to configure proper image to be displayed according to the device size

```angular2html
<picture>
  <source media="(min-width: 800px)" srcset="head.jpg, head-2x.jpg 2x">
  <source media="(min-width: 450px)" srcset="head-small.jpg, head-small-2x.jpg 2x">
  <img src="head-fb.jpg" srcset="head-fb-2x.jpg 2x" alt="a head carved out of wood">
</picture>
```

For example, here when the screen size is big, it will display the head and head-2x high resolution image
whereas when the screen size is small, it will display the small version of them
If the browser doesn't support picture tag, it can also fall back to regular img.
Here the media attribute is used to specify screen size boundry and srcset is used to define specific image to display in different cases


2. Benefits:
- make image display more responsive with respect to the screen size 
- Allow displaying different images depending on device characteristics
- the srcset give browser hints about the best image to use for best visial effect

3. Disadvantage: One possible drawback of using picture is that instead of supplying one image, we might potentially need to include multiple resolution/dimension of the similar image which might increase the amount of work needs to be done to develop the site, also need more storage to store these images.
To mitigate the issue, there are tools available where different  resolution of same image can be auto-generated which will save a lot of effort
