import { TrashIcon } from "lucide-react";
import { Button } from "@/components/ui/button";
import { Puppy } from "@/types";
import {
  AlertDialog,
  AlertDialogAction,
  AlertDialogCancel,
  AlertDialogContent,
  AlertDialogDescription,
  AlertDialogFooter,
  AlertDialogHeader,
  AlertDialogTitle,
  AlertDialogTrigger
} from "@/components/ui/alert-dialog";
import { Form } from "@inertiajs/react";
import { deleteMethod } from "@/routes/puppies";

export function PuppyDelete({ puppy }: { puppy: Puppy, }) {
  return (
    <div>

      <AlertDialog>
        <AlertDialogTrigger asChild>
          <Button size="icon" variant="destructive" aria-label="Delete puppy">
            <TrashIcon className="size-4" />
          </Button>
        </AlertDialogTrigger>
        <AlertDialogContent>
          <AlertDialogHeader>
            <AlertDialogTitle>Are you absolutely sure?</AlertDialogTitle>
            <AlertDialogDescription>
              Who in their right mind would delete such a cute puppy? Seriously?
            </AlertDialogDescription>
          </AlertDialogHeader>
          <AlertDialogFooter>
            <AlertDialogCancel>Cancel</AlertDialogCancel>
            <Form
              method="delete"
              action={deleteMethod(puppy.id)}
              options={{
                preserveScroll: true,
              }}
            >
              {({ processing }) => (
                <AlertDialogAction type="submit">Delete {puppy.name}</AlertDialogAction>
              )}
            </Form>
          </AlertDialogFooter>
        </AlertDialogContent>
      </AlertDialog>
    </div>
  )
}
