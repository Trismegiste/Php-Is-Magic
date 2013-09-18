# Messy code like Javascript

You like Javascript and its lack of classes ?

## What

Thanks to this trait, you can mess your project with javascript-like notation
of objects. There is no strong-typing nor validation possibilities.

# How

Use the trait Glued in your class :

```php
class MyMessyObject {
    use Glued;
    protected $data = 6;
}

$obj = new MyMessyObject();
$obj->someMethod = function($arg) {
    return $arg * $this->data;
}
echo $obj->someMethod(7);
// output "42" !
```

Wonderful, isn't it ?

Now you can screw your project with this hidden coupling generator !

## Why

Because, like the H-Bomb, we can !

## Note

There is a trick about subclassing MyMessyObject and private properties :
Read comments and unit tests regarding the scope of bound closure.