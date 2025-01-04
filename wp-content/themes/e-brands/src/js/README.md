**Table Of Content**

[[_TOC_]]

<br>
<br>

---

<br>
<br>

# Instruction for Executing Functions based on Flexible Sections

1. Add a class name on the flexible section markup so that we can get the section on the js.

    ```html
    <section class="flexible-section">
    	<!-- Flexible Section content -->
    </section>
    ```

2. Navigate to `./components/flexibleContents.js` file. On it find the **flexibleContents** object and add the flexible section selector to it.

    ```js
    const flexibleContents = {
    	sectionName: ".flexible-section",
    };
    ```

    On this file, it checks whether the section is on the page or not and exports **sections** which contains the array of section containing on the page.

3. On **main.js** file, create a **Init** Object which we will use to call function based on Flexible content.

    ```js
    const Init = {};
    ```

4. Create a **CommonJS** function inside the **Init** object to execute function common to all pages.

    ```js
    const Init = {
    	CommonJS() {
    		// Functions/modules common to all pages goes here
    		Navigation.init();
    	},
    };
    ```

5. Now, create functions based on the flexible Section name declared on the **flexibleContents** object in `./components/flexibleContents.js` file .

    ```js
    const Init = {
    	CommonJS() {
    		// Functions/modules common to all pages goes here
    	},
    	// the function name should be same as the key from flexibleContents object on flexibleContents.js file
    	sectionName() {
    		// Function specific to this section only
    	},
    };
    ```

6. On **index.js** file, import the **sections** from the `./js/components/flexibleContents.js` file and **Init** from `./js/main.js`.

    ```js
    import Init from "./js/main.js";
    import sections from "./js/components/flexibleContents";
    ```

7. Finally, Call the function inside **Init** object by comparing the function name with the imported **sections**.

    ```js
    // First call the commonJS
    Init.commonJS();

    // Then loop through the Init object
    for (const section in Init) {
    	if (Init.hasOwnProperty(section)) {
    		// Check if section is on the page or not by comparing it to the imported section
    		if (sections.includes(section)) {
    			Init[section]();
    		}
    	}
    }
    ```

## Issue With Above Approach

When flexible-sections have to execute the same function, it will execute it the number of times it is called.

```js
function foo() {
	console.log("foo executed");
}

const Init = {
	commonJS() {},
	banner() {
		foo(); // 1
	},
	slider() {
		foo(); // 2
	},
	zigzag() {
		foo(); // 3
	},
	imageCol() {
		foo(); // 4
	},
};

for (const section in Init) {
	if (Init.hasOwnProperty(section)) {
		if (sections.includes(section)) {
			Init[section]();
		}
	}
}
```

Lets say the page contains **banner**, **slider** and **zigzag** sections. So, it will execute these functions from **Init** object. Here, all the section have a common function **foo()** and this function will execute 3 times even though we only need to call it one time.

```js
// Console output
foo executed
foo executed
foo executed
```

## Exception for above case

If the function takes arguments the above issue can be ignored.

```js
function foo(arg) {
	console.log(arg);
}

const Init = {
	commonJS() {},
	banner() {
		foo("banner executed"); // 1
	},
	slider() {
		foo("slider executed"); // 2
	},
	zigzag() {
		foo("zigzag executed"); // 3
	},
	imageCol() {
		foo("imageCol executed"); // 4
	},
};
```

In this case, even if the function **foo()** is called multiple times but different argument is passed each times. So, the output will not be same each time.

```js
// Console output
banner executed
slider executed
zigzag executed
```

## How to Solve the Issue

To solve the issue, what we can do is check if the function is executed or not and if executed do not execute again. We can do this by updating the above function as shown on the code snippet below:

```js
let fooExecuted = false;

function foo() {
	console.log("foo executed");
}

function executeFoo(){
    if(!fooExecuted){
        foo();
        fooExecute = true;
    }
}

const Init = {
	commonJS() {},
	banner() {
		executeFoo(); // 1
	},
	slider() {
		executeFoo(); // 2
	},
	zigzag() {
		executeFoo(); // 3
	},
	imageCol() {
		executeFoo(); // 4
	},
};

// Console Output
foo executed
```

Now, the function is executed only once.

<br>
<br>

---

<br>
<br>

# Swiper Slider Usage

We have js module **sliders.js** inside the `./components/` directory. Here is how to use this module.

First of all we need to import this module on our **main.js**. **sliders.js** exports an object named **Slider**, so we will import it.

```js
//main.js
import { Slider } from "./components/sliders";
```

After importing the module, we can now use it in out project.

## Usage

To initialize the slider, we need to call the **init** function. The **init** function takes an object as an argument which takes three values **selector**, **settings** and **handler**.

```js
Slider.init({
	selector: ".swiper", // default
	settings: {
		// Default settings
		speed: 400,
		spaceBetween: 100,
		slidesPerView: 1,
	},
	handler: (slider) => {
		slider.update();
	},
});
```

You could call the init function without any arguments and will still initialize the slider with default options.

```js
Slider.init();
```

### Slider Options

The slider takes an object as an argument and the object takes three values which are mentioned above. So, what does this option do and what type of values does it accepts?

1. **selector**: It takes a **string** which is a valid **css selector**.

```js
//Default selector
{
	selector: ".swiper";
}
```

2. **settings**: It takes an **object** and it takes all parameters from **Swiper**.

```js
//Default settings
{
	settings: {
		speed: 400,
		spaceBetween: 100,
		slidesPerView: 1,
	}
}
```

3. **handler**: It takes a **function** and the function takes an parameter which is the initialized instance of the swiper. Handler is used to handle the methods, properties, events and modules of Swiper.

```js
{
	handler: (slider) => {
		slider.disable();
	};
}
```
