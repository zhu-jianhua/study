function same_class_name ($string1, $string2) {
  return ((strtolower($string1)) ==
          (strtolower($string2)));
}

function get_child_classes ($parent) {
  $all_classes = get_declared_classes();
  $children = array();
  foreach ($all_classes as $candidate) {
    if (same_class_name($parent,
          get_parent_class($candidate)) &&
        !same_class_name($parent, $candidate)) {
      array_push($children, $candidate);
    }
  }
  return($children);
}

function print_class_tree () {
  $all_classes = get_declared_classes();
  print("<PRE>");
  print("CLASS HIERARCHY:\n");
    foreach ($all_classes as $candidate) {
      if (!get_parent_class($candidate)) {
        print_class_tree_aux($candidate, 0);
      }
    }
  print("</PRE>");
}

function print_class_tree_aux ($parent, $level) {
  for ($x = 0; $x < $level; $x++) {
    print("    ");
  }
  print("$parent<BR>");
  $children = get_child_classes($parent);
  foreach ($children as $child) {
    print_class_tree_aux($child, $level + 1);
  }
}
print_class_tree();
