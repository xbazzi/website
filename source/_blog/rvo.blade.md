---
extends: _layouts.blog 
title: Optimizing Return Value Optimization
author: Xander Bazzi
date: 2025-01-25
collaborators: nobody
image: /assets/img/rvo.png
url: /blog/rvo/index.html
section: content
---

<h1 class="text-verde">Optimizing RVO</h1>

Look at the code snippet below. How many times is `MyType{}` constructed? What about `std::optional<MyType>`?

```cpp
std::optional<MyType> get_mytype(std::uint64_t some_val) {
    if (!some_val) {
        return std::nullopt;
    }
    return MyType{};
}
```

If you've used C++17's `std::optional`, you might have code that resembles the above. But is this the proper way of returning an `optional`? Let's reason about it:
1)   We call the `MyType` default constructor
2)   Then we call the optional copy constructor _implicitly_ with the `MyType` value. Wait, but then are we constructing two objects? One `optional` and one `MyType`?
3)   No, that can't be... We must be constructing the `MyType` r-value inside the optional. But then that means the `optional` had to be constructed prior...

After going throught these mental gymnastics, you might reach the conclusion that there are technically *two* constructions. And reasonably so, you might also assume that the compiler will optimize them both into a single in-place construction of an `optional` with the corresponding `MyType` object (somehow). Unfortunately, in true CPP fashion, this couldn't be further from the truth.

Let's replace our `get_mytype` function with something a little more useful. To help us get some insight into the object lifetime, let's write a function that returns a canonical `Lifetime` [tracker](https://github.com/xbazzi/programmatic-playground/blob/master/cpp/my_std_lib/Lifetime.cc):

```cpp
std::optional<Lifetime> get_lifetime(std::uint64_t key)
{
    if (key < 42ULL) {
        return std::nullopt;
    }
    return Lifetime {};
}
```

And let's suppose we call it with:

```cpp
auto main() -> int {
    std::optional<Lifetime> a = get_lifetime(100ULL);
}
```

Which generates the following output:
```text
1       Lifetime::Lifetime()
2->1    Lifetime::Lifetime(Lifetime&&)
2       Lifetime::~Lifetime()
1       Lifetime::~Lifetime()
```

Inspecting the result, we can see that there are two constructions in total (and two corresponding destructions):
    - One *default construction* of the unnamed `Lifetime` from the `get_lifetime()` function
    - And another *move construction* by moving that temporary into `a` in the `main()` (caller) context

<blockquote class="border-l-4 border-blue-400 bg-amber-50 p-4 italic my-4 text-black">
I know what you're thinking: "the compiler will optimize both of these into one construction". And you'd be correct. These issues only manifest themselves with -O0. You actually have nothing to worry about. Unless your function is not inline-able or you <a href="https://www.youtube.com/watch?v=DzUAqXMUjtc" class="text-blue-300 hover:text-blue-200">somehow mess up RVO</a>.
</blockquote>

You probably expected C++17's guaranteed copy-elision (for unnamed RVO) to completely skip the construction inside `get_lifetime()` and instead just construct it at the caller site. The only problem is that URVO is only guaranteed when the return type *exactly matches* the caller type. In our case, a `Lifetime` _is not_ an `std::optional<Lifetime>`, so we need to first construct the `Lifetime` and call the `std::optional<Lifetime>` constructor (which moves or copies the `Lifetime`).

To tell `std::optional` that we want to construct a `Lifetime` in-place, we have to use `std::in_place`; bet you didn't see that one coming. Here's the revised correct copy-elided version that leverages URVO:

```cpp
std::optional<Lifetime> get_lifetime(std::uint64_t key)
{
    if (key < 42ULL) {
        return std::nullopt;
    }
    return std::optional<Lifetime> {std::in_place};
}
```

Now we get the expected behavior: the `Lifetime` constructor is called _once_.
```text
1       Lifetime::Lifetime()
1       Lifetime::~Lifetime()
```

Yes, there is an `std::optional` parameterized constructor that takes in an `std::in_place`. Same thing goes for `std::expected`, `std::tuple`, `std::pair`, and probably other STL wrappers. 

![std::optional constructors](/assets/img/optional_ctors.png)

Another C++ idiosyncracy to be aware of. On to the next one.
