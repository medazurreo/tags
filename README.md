cloudProject
============

A Symfony project created on December 21, 2016, 10:05 pm.


Process:

tagBundle ==> entity(tag) ==> 
postType ==> TagsType (add new type in TagBundle\Form\Type with getParent witch return TextType )
==> addTransformer in buildForm method: we will create DataTransformer/TagsTransformer.php