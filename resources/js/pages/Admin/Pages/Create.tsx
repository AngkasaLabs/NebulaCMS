import { Head, useForm } from '@inertiajs/react';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import {
  Select,
  SelectContent,
  SelectItem,
  SelectTrigger,
  SelectValue,
} from '@/components/ui/select';
import { Textarea } from '@/components/ui/textarea';
import { toast } from 'sonner';
import AppLayout from '@/layouts/app-layout';
import { Editor } from '@/components/editor';
import { Label } from '@/components/ui/label';
import { Card, CardContent, CardHeader, CardTitle } from '@/components/ui/card';
import { useCallback } from 'react';

const breadcrumbs = [
  {
    title: 'Dashboard',
    href: route('admin.dashboard'),
  },
  {
    title: 'Pages',
    href: route('admin.pages.index'),
  },
  {
    title: 'Create',
  },
];

export default function Create() {
  const { data, setData, post, processing, errors } = useForm({
    title: '',
    content: '',
    meta_description: '',
    meta_keywords: '',
    status: 'draft',
    order: 0,
  });

  const handleSubmit = useCallback(
    (e: React.FormEvent) => {
      e.preventDefault();
      post(route('pages.store'), {
        onSuccess: () => {
          toast.success('Halaman berhasil dibuat');
        },
      });
    },
    [post]
  );

  return (
    <AppLayout breadcrumbs={breadcrumbs}>
      <Head title="Create Page" />

      <div className="p-4">
        <form onSubmit={handleSubmit}>
          <div className="flex justify-between items-center mb-6">
            <h1 className="text-2xl font-bold">Create New Page</h1>
            <div className="flex gap-2">
              <Button
                type="submit"
                disabled={processing}
              >
                Save
              </Button>
            </div>
          </div>

          <div className="grid grid-cols-1 lg:grid-cols-3 gap-4">
            <div className="lg:col-span-2 space-y-4">
              <Card>
                <CardHeader>
                  <CardTitle>Content</CardTitle>
                </CardHeader>
                <CardContent className="space-y-4">
                  <div className="space-y-2">
                    <Label htmlFor="title">Title</Label>
                    <Input
                      id="title"
                      value={data.title}
                      onChange={(e) => setData('title', e.target.value)}
                      placeholder="Enter page title"
                    />
                    {errors.title && (
                      <span className="text-sm text-red-500">{errors.title}</span>
                    )}
                  </div>

                  <div className="space-y-2">
                    <Label>Content</Label>
                    <Editor
                      value={data.content}
                      onChange={(value) => setData('content', value)}
                    />
                    {errors.content && (
                      <span className="text-sm text-red-500">{errors.content}</span>
                    )}
                  </div>
                </CardContent>
              </Card>
            </div>

            <div className="space-y-4">
              <Card>
                <CardHeader>
                  <CardTitle>Settings</CardTitle>
                </CardHeader>
                <CardContent className="space-y-4">
                  <div className="space-y-2">
                    <Label htmlFor="status">Status</Label>
                    <Select
                      value={data.status}
                      onValueChange={(value) => setData('status', value)}
                    >
                      <SelectTrigger>
                        <SelectValue placeholder="Pilih status" />
                      </SelectTrigger>
                      <SelectContent>
                        <SelectItem value="draft">Draft</SelectItem>
                        <SelectItem value="published">Published</SelectItem>
                      </SelectContent>
                    </Select>
                    {errors.status && (
                      <span className="text-sm text-red-500">{errors.status}</span>
                    )}
                  </div>

                  <div className="space-y-2">
                    <Label htmlFor="order">Order</Label>
                    <Input
                      id="order"
                      type="number"
                      value={data.order}
                      onChange={(e) => setData('order', Number(e.target.value))}
                    />
                    {errors.order && (
                      <span className="text-sm text-red-500">{errors.order}</span>
                    )}
                  </div>
                </CardContent>
              </Card>

              <Card>
                <CardHeader>
                  <CardTitle>SEO</CardTitle>
                </CardHeader>
                <CardContent className="space-y-4">
                  <div className="space-y-2">
                    <Label htmlFor="meta_description">Meta Description</Label>
                    <Textarea
                      id="meta_description"
                      value={data.meta_description}
                      onChange={(e) => setData('meta_description', e.target.value)}
                      placeholder="Enter meta description for SEO"
                      rows={3}
                    />
                    {errors.meta_description && (
                      <span className="text-sm text-red-500">
                        {errors.meta_description}
                      </span>
                    )}
                  </div>

                  <div className="space-y-2">
                    <Label htmlFor="meta_keywords">Meta Keywords</Label>
                    <Input
                      id="meta_keywords"
                      value={data.meta_keywords}
                      onChange={(e) => setData('meta_keywords', e.target.value)}
                      placeholder="Enter meta keywords for SEO"
                    />
                    {errors.meta_keywords && (
                      <span className="text-sm text-red-500">
                        {errors.meta_keywords}
                      </span>
                    )}
                  </div>
                </CardContent>
              </Card>
            </div>
          </div>
        </form>
      </div>
    </AppLayout>
  );
}
