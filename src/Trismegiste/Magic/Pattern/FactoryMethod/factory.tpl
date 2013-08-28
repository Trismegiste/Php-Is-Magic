namespace _NamespaceProduct_;

interface _ProductFactory_
{

    public function create();
}

class _ConcreteProductFactory_ implements _ProductFactory_
{

    public function create()
    {
        $refl = new \ReflectionClass('_FqcnProduct_');
        return $refl->newInstanceArgs(func_get_args());
    }

}
